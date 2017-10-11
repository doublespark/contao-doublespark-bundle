<?php

/**
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] =  str_replace
(
	'alias,',
	'alias,rel_canonical,canonical_use_page_url,rel_canonical_url,',
	$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'] = array(array('tl_ds_page', 'generateAlias'));

// Fields
$GLOBALS['TL_DCA']['tl_page']['fields']['rel_canonical'] = array
(
	'label'         => array('Canonical alias', 'This will be used in the rel="canonical" tag in the page head.'),
	'exclude'       => true,
	'inputType'     => 'text',
	'eval'          => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'clr'),
	'sql'           => "varchar(128) NOT NULL default ''",
	'save_callback' => array
	(
		array('tl_ds_page', 'generateCanonical')
	)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['rel_canonical_url'] = array
(
	'label'         => array('Canonical URL', 'A full URL. Unless empty, this will override the canonical value with a full URL.'),
	'exclude'       => true,
	'inputType'     => 'text',
	'sql'           => "varchar(128) NOT NULL default ''",
	'eval'          => array('rgxp'=>'url', 'doNotCopy'=>true)
);

// Fields
$GLOBALS['TL_DCA']['tl_page']['fields']['canonical_use_page_url'] = array
(
	'label'         => array('Use page URL for canonical', 'Ticking this box will set the conanical attribute to the URL of this page. (Use on news and event reader pages)'),
	'exclude'       => true,
	'inputType'     => 'checkbox',
	'sql'           => "char(1) NOT NULL default ''",
	'eval'          => array('tl_class'=>'block', 'style' => 'overflow:hidden; clear:both; margin-top:15px;'),
);

/**
 * Class tl_ds_page
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2013
 * @author     Leo Feyer <https://contao.org>
 * @package    Controller
 */
class tl_ds_page extends \Backend
{
	/**
	 * Auto-generate a page alias if it has not been set yet
	 * @param mixed
	 * @param DataContainer
	 * @return string
	 */
	public function generateCanonical($varValue, DataContainer $dc)
	{
		// Generate an alias if there is none
		if ($varValue == '')
        {
            $varValue = \StringUtil::restoreBasicEntities($varValue);
			$varValue = standardize($varValue);
		}

		return $varValue;
	}

    /**
     * Auto-generate the news alias if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if ($varValue == '')
        {
            $autoAlias = true;
            $varValue = strtolower(StringUtil::generateAlias($dc->activeRecord->title));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_page WHERE alias=?")
            ->execute($varValue);

        // Check whether the news alias exists
        if ($objAlias->numRows > 1 && !$autoAlias)
        {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        // Add ID to alias
        if ($objAlias->numRows && $autoAlias)
        {
            $varValue .= '-' . $dc->id;
        }

        // Enforce lower case alias
        return strtolower($varValue);
    }
}