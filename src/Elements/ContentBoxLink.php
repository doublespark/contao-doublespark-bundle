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
 * Class ContentBoxLink
 *
 * @copyright  Doublespark 2016
 * @author     Jamie Devine
 */
class ContentBoxLink extends \Contao\ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_boxlink';


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
		$this->Template->headline   = $this->headline;
		$this->Template->singleSRC  = \Image::get($this->singleSRC,580,350,'crop');
        $this->Template->subHeading = $this->linkbox_subheading;
        $this->Template->linkTitle  = $this->linkTitle ? $this->linkTitle : 'View more';
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