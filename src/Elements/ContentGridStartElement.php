<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Doublespark\Doublespark\Elements;


use Contao\BackendTemplate;
use Contao\ContentElement;
use Patchwork\Utf8;

/**
 * Class DoubleTextElement
 *
 * @copyright  Doublespark 2016
 * @author     Jamie Devine
 */
class ContentGridStartElement extends ContentElement
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_content_grid';

	public function generate()
	{
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### GRID START ('.$this->ds_content_grid_columns.' COLUMNS) ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
        $this->Template->type = 'start';
	}
}