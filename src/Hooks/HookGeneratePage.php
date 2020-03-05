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
        $canonicalURL = Environment::get('uri');

        // If a manual URL has been entered, use this instead
        if(!empty($objPage->rel_canonical_url))
        {
            $canonicalURL = $objPage->rel_canonical_url;
        }

        $GLOBALS['TL_HEAD'][] = '<link rel="canonical" href="'. rtrim($canonicalURL,'/') .'" />';
    }
}