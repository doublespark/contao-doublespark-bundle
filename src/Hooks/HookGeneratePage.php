<?php

namespace Doublespark\Doublespark\Hooks;

use Contao\Environment;
use Contao\PageModel;

class HookGeneratePage
{
    /**
     * Add canonical tag to pages
     * @param PageModel $objPage
     */
    public function addCanonicalTag(PageModel $objPage)
    {
        // Canonical disabled
        if($objPage->disable_canonical)
        {
            return;
        }

        $canonicalURL = Environment::get('uri');

        // If a manual URL has been entered, use this instead
        if(!empty($objPage->rel_canonical_url))
        {
            $canonicalURL = $objPage->rel_canonical_url;
        }

        if($objPage->strip_query_strings)
        {
            $canonicalURL = strtok($canonicalURL,'?');
        }

        if(!isset($GLOBALS['TL_HEAD']['dsCanonical']))
        {
            $GLOBALS['TL_HEAD']['dsCanonical'] = '<link rel="canonical" href="'. $canonicalURL .'" />';
        }
    }
}