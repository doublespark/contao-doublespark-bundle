<?php

namespace Doublespark\BackendModules;

use Contao\BackendModule;
use Contao\PageModel;
use League\Csv\Reader;
use League\Csv\Writer;

class MetaImportExport extends BackendModule {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_meta_import_export';

    /**
     * Field map
     * array['Label'] = 'database_field_name'
     * @var array
     */
    protected $arrFieldMap = [
        'Page ID' => 'id',
        'Title' => 'title',
        'Alias' => 'alias',
        'Meta title' => 'pageTitle',
        'Meta description' => 'description'
    ];

    protected $errors = array();

    protected $messages = array();

    protected $warnings = array();

    protected $arrExportPageIds = array();

    /**
     * Generate the module
     * @return void
     */
    protected function compile()
    {
        if(\Input::post('FORM_SUBMIT') == 'IMPORT_CSV')
        {
            $this->handleImport();
        }

        if(\Input::post('FORM_SUBMIT') == 'EXPORT_CSV')
        {
            $this->handleExport();
        }

        $objRootPages = \PageModel::findBy('type','root');

        $arrRootPages = array();

        if($objRootPages)
        {
            while($objRootPages->next())
            {
                $arrRootPages[$objRootPages->id] = $objRootPages->title;
            }
        }

        $this->Template->errors   = $this->errors;
        $this->Template->messages = $this->messages;
        $this->Template->warnings = $this->warnings;

        $this->Template->arrRootPages = $arrRootPages;

        $this->Template->rt = \RequestToken::get();
    }

    protected function handleImport()
    {
        if(isset($_FILES['meta_csv']['name']) AND !empty($_FILES['meta_csv']['name']))
        {
            $ext = pathinfo($_FILES['meta_csv']['name'],PATHINFO_EXTENSION);

            if($ext !== 'csv')
            {
                $this->errors[] = 'Please ensure uploaded file is a CSV';
                return;
            }

            $file = $_FILES['meta_csv']['tmp_name'];

            $csv = Reader::createFromPath($file);

            $arrImport = $csv->fetchAssoc(0);

            $i  = 0;
            $rc = 1;

            // Handle each row of the CSV
            foreach($arrImport as $row)
            {
                $rc++;

                $pageRow = array();

                // Covert keys from labels to database fields
                foreach($row as $k => $v)
                {
                    $pageRow[$this->arrFieldMap[$k]] = $v;
                }

                if(!isset($pageRow['id']) || empty($pageRow['id']))
                {
                    $this->warnings[] = 'Row '.$rc.': missing page ID.';
                    continue;
                }

                // Find page object
                $objPage = \PageModel::findByPk($pageRow['id']);

                // Update and save page object
                if(!is_null($objPage))
                {
                    unset($pageRow['id']);

                    foreach($pageRow as $field => $value)
                    {
                        $objPage->$field = $value;
                    }

                    $objPage->save();

                    $i++;
                }
                else
                {
                    $this->warnings[] = 'Row '.$rc.': page with ID '.$pageRow['id'].' not found, row skipped.';
                }
            }

            $this->messages[] = 'Import complete. Updated '.$i.' rows';
        }
        else
        {
            $this->errors[] = 'No file was uploaded';
        }
    }

    protected function handleExport()
    {
        $arrPageIds = \Input::post('roots');

        if(!is_array($arrPageIds) || count($arrPageIds) < 1)
        {
            $this->errors[] = 'Please select at least one site to export';
            return;
        }

        $this->getPagesByPids($arrPageIds);

        $objPageDetails = \Database::getInstance()->prepare('SELECT id, title, alias, pageTitle, description FROM tl_page WHERE id IN('.implode(',',$this->arrExportPageIds).')')->execute();

        if($objPageDetails->numRows > 0)
        {
            $arrExportRows = array();

            // Header row
            $row = array();

            foreach($this->arrFieldMap as $label => $field)
            {
                $row[] = $label;
            }

            $arrExportRows[] = $row;

            // Build page rows
            while($objPageDetails->next())
            {
                $row = array();

                foreach($this->arrFieldMap as $label => $field)
                {
                    $row[] = $objPageDetails->$field;
                }

                $arrExportRows[] = $row;
            }

            // Create CSV
            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            $csv->insertAll($arrExportRows);
            $csv->output('page-meta-'.date('dmY').'.csv');
            die;
        }
    }

    protected function getPagesByPids($arrPids)
    {
        $objPages = \Database::getInstance()->query('SELECT id FROM tl_page WHERE pid IN('.implode(',',$arrPids).')');

        if($objPages->numRows > 0)
        {
            $arrPids = array();

            while($objPages->next())
            {
                $this->arrExportPageIds[] = $objPages->id;
                $arrPids[] = $objPages->id;
            }

            $this->getPagesByPids($arrPids);
        }
    }
}