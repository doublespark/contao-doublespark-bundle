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

	public function generate()
	{
		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
	}
}