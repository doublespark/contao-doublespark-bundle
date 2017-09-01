<?php

/**
 * Table tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['fields']['alias']['save_callback'] = array(array('tl_ds_news', 'generateAlias'));

/**
 * Class tl_ds_news
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_ds_news extends \Backend
{
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
            $varValue = strtolower(StringUtil::generateAlias($dc->activeRecord->headline));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_news WHERE alias=?")
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