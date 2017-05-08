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
namespace Doublespark\Elements;


/**
 * Class ParallaxSectionElement
 *
 * @copyright  Doublespark 2016
 * @author     Jamie Devine
 */
class ParallaxSectionElement extends \Contao\ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_parallax_section';

    /**
     * Counter to increment CSS ids of screens
     * @var int
     */
    protected $screensCount = 0;

	/**
	 * Return if the image does not exist
	 * @return string
	 */
	public function generate()
	{
		if($this->singleSRC == '')
		{
			return '';
		}

		$objFile = \FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null)
		{
			if (!\Validator::isUuid($this->singleSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

		if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
		{
			return '';
		}

		$this->singleSRC = $objFile->path;

		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
	    $cssID = 'parallax'.$this->id;

        // Append to existing style tag or create a new one
        if(isset($GLOBALS['TL_HEAD']['parallax']))
        {
            $GLOBALS['TL_HEAD']['parallax'] = str_replace('</style>',"\n#".$cssID."{background-image:url('".$this->singleSRC."');}</style>",$GLOBALS['TL_HEAD']['parallax']);
        }
        else
        {
            $GLOBALS['TL_HEAD']['parallax'] = '<style type="text/css">#'.$cssID.'{background-image:url(\''.$this->singleSRC.'\');}</style>';
        }

        if($this->addScreenLeft)
        {
            $this->Template->leftScreenHTML = $this->getScreenHtml($this->leftScreenSRC);
        }

        if($this->addScreenRight)
        {
            $this->Template->rightScreenHTML = $this->getScreenHtml($this->rightScreenSRC);
        }

		// Template vars
        $this->Template->elementID = $cssID;
	}

    /**
     * Generates a screen HTML element
     * @param $src
     * @return string
     */
	protected function getScreenHtml($src)
    {
        $this->screensCount++;

        $objModel = new \ContentModel();
        $objModel->id = $this->id.$this->screensCount;
        $objModel->singleSRC = $src;
        $objModel->type = 'computer_image';

        $objComputerImage = new ComputerImageElement($objModel);
        return $objComputerImage->generate();
    }

	/**
	 * Fetches a file path based on it's uuid, returns false if file doesn't exist
	 * @param  String $uuid
	 * @return Mixed
	 */
	protected function fetchFilePath($uuid)
	{
		$objFile = \FilesModel::findByUuid($uuid);

		if($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
		{
			return FALSE;
		}

		return $objFile->path;
	}
}