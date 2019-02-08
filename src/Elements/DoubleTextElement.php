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


/**
 * Class DoubleTextElement
 *
 * @copyright  Doublespark 2016
 * @author     Jamie Devine
 */
class DoubleTextElement extends \Contao\ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_double_text';

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
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
        if($this->addScreenLeft)
        {
            $this->Template->leftScreenHTML = $this->getScreenHtml($this->leftScreenSRC);
        }

        if($this->addScreenRight)
        {
            $this->Template->rightScreenHTML = $this->getScreenHtml($this->rightScreenSRC);
        }
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