<?php

use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend JS
 */
if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))
{
    // JS
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/doublespark/js/wordCount.js|static';
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/doublespark/js/saveButton.js|static';

    // CSS
    $GLOBALS['TL_CSS'][] = 'bundles/doublespark/css/wordCount.css|static';
    $GLOBALS['TL_CSS'][] = 'bundles/doublespark/css/saveButton.css|static';
}

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['ds_meta_imex'] = [
    'callback' => 'Doublespark\Doublespark\BackendModules\MetaImportExport'
];

/**
 * Mark elements as wrappers
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'ds_content_grid_start';
$GLOBALS['TL_WRAPPERS']['stop'][]  = 'ds_content_grid_end';