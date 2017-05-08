<?php

namespace Doublespark\Hooks;

use Contao\PageModel;

class HookGeneratePage
{
    /**
     * Add canonical tag to pages
     * @param PageModel $objPage
     */
    public function addCanonicalTag(PageModel $objPage)
    {
        // Default location
        $location= '/';

        if(!empty($objPage->rel_canonical) AND !in_array($objPage->rel_canonical,['home','index']) AND $objPage->canonical_use_page_url != 1)
        {
            // Isn't blank and isn't home so use the canonical field value
            $location =  '/' . $objPage->rel_canonical;
        }
        elseif($objPage->canonical_use_page_url == 1)
        {
            // Use page URL
            $arrUri= explode('?',$_SERVER['REQUEST_URI']);

            // Remove any query strings
            $location = $arrUri[0];
        }
        elseif(!in_array($objPage->alias,['home','index']))
        {
            // Is blank, use alias
            $location = '/' . $objPage->alias;
        }

        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';

        // This is the full URL
        $canonicalURL = $protocol . $_SERVER['HTTP_HOST'] . $location .  $GLOBALS['TL_CONFIG']['urlSuffix'];

        // If a manual URL has been entered, use this instead
        if(!empty($objPage->rel_canonical_url))
        {
            $canonicalURL = $objPage->rel_canonical_url;
        }

        $GLOBALS['TL_HEAD'][] = '<link rel="canonical" href="'. $canonicalURL .'" />';
    }
}