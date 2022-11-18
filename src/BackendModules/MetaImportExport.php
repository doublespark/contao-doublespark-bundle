<?php

namespace Doublespark\Doublespark\BackendModules;

use Contao\BackendModule;
use Contao\Database;
use Contao\Input;
use Contao\PageModel;
use Contao\System;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

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
    protected array $arrFieldMap = [
        'Page ID' => 'id',
        'Title' => 'title',
        'Alias' => 'alias',
        'Meta title' => 'pageTitle',
        'Title Chars' => null,
        'Meta description' => 'description',
        'Desc Chars' => null
    ];

    /**
     * @var array
     */
    protected array $errors   = [];

    /**
     * @var array
     */
    protected array $messages = [];

    /**
     * @var array
     */
    protected array $warnings = [];

    /**
     * Generate the module
     * @return void
     */
    protected function compile(): void
    {
        if(Input::post('FORM_SUBMIT') == 'IMPORT_CSV')
        {
            $this->handleImport();
        }

        if(Input::post('FORM_SUBMIT') == 'EXPORT_CSV')
        {
            $this->handleExport();
        }

        $objRootPages = PageModel::findBy('type','root');

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

        /**
         * @var CsrfTokenManagerInterface $csrfTokenManager
         */
        $csrfTokenManager = System::getContainer()->get('contao.csrf.token_manager');
        $csrfTokenName    = System::getContainer()->getParameter('contao.csrf_token_name');

        $this->Template->rt = $csrfTokenManager->getToken($csrfTokenName)->getValue();
    }

    protected function handleImport(): void
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

            $csv->setHeaderOffset(0);

            $i  = 0;
            $rc = 1;

            $records = $csv->getRecords();

            // Handle each row of the CSV
            foreach($records as $row)
            {
                $rc++;

                $pageRow = array();

                // Covert keys from labels to database fields
                foreach($row as $k => $v)
                {
                    if(isset($this->arrFieldMap[$k]))
                    {
                        $pageRow[$this->arrFieldMap[$k]] = $v;
                    }
                }

                if(empty($pageRow['id']))
                {
                    $this->warnings[] = 'Row '.$rc.': missing page ID.';
                    continue;
                }

                // Find page object
                $objPage = PageModel::findByPk($pageRow['id']);

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
        $arrRootPageIds = Input::post('roots');

        if(!is_array($arrRootPageIds) || count($arrRootPageIds) < 1)
        {
            $this->errors[] = 'Please select at least one site to export';
            return;
        }

        // This will hold the rows to be exported
        $arrExportRows = [];

        // Header row
        $row = [];

        // Generate the first (header) row form the field map labels
        foreach($this->arrFieldMap as $label => $field)
        {
            $row[] = $label;
        }

        $arrExportRows[] = $row;

        foreach($arrRootPageIds as $rootPageId)
        {
            $arrExportPageIds = $this->getPagesThatBelongToRoot($rootPageId);

            $objPageDetails = Database::getInstance()->prepare('SELECT id, title, alias, pageTitle, description FROM tl_page WHERE published=1 AND id IN('.implode(',',$arrExportPageIds).')')->execute();

            // Items will start on row 2 of the CSV
            $rowNumber = 2;

            if($objPageDetails->numRows > 0)
            {
                // Build page rows
                while($objPageDetails->next())
                {
                    $row = [];

                    foreach($this->arrFieldMap as $label => $field)
                    {
                        if(!empty($field))
                        {
                            $row[] = $objPageDetails->$field;
                        }

                        if($label === 'Title Chars')
                        {
                            $row[] = '=LEN(D'.$rowNumber.')';
                        }

                        if($label === 'Desc Chars')
                        {
                            $row[] = '=LEN(F'.$rowNumber.')';
                        }
                    }

                    $rowNumber++;

                    $arrExportRows[] = $row;
                }
            }
        }

        // Create CSV
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertAll($arrExportRows);
        $csv->output('page-meta-'.date('dmY').'.csv');
        die;
    }


    /**
     * Find all child pages from a collection of parent page IDs
     * @param array $arrSearchPids
     * @param array $arrPageIds
     * @return array
     */
    protected function getPagesByPids(array $arrSearchPids, array &$arrPageIds = []): array
    {
        $objPages = Database::getInstance()->query('SELECT id FROM tl_page WHERE pid IN('.implode(',',$arrSearchPids).')');

        if($objPages->numRows > 0)
        {
            $arrIds = [];

            while($objPages->next())
            {
                $arrIds[]     = $objPages->id; // This is just for the page IDs fetched in this batch
                $arrPageIds[] = $objPages->id; // This is passed by reference and contains all the previously fetched pageIds
            }

            $this->getPagesByPids($arrIds,$arrPageIds);
        }

        return $arrPageIds;
    }

    /**
     * Get all child pages of a root page
     * @param int $rootPageId
     * @return array
     */
    protected function getPagesThatBelongToRoot(int $rootPageId): array
    {
        return $this->getPagesByPids([$rootPageId]);
    }
}