<?php

use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend JS
 */
if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))
{
    // JS
    $GLOBALS['TL_JAVASCRIPT'][] = '/bundles/doublespark/js/wordCount.js';
    $GLOBALS['TL_JAVASCRIPT'][] = '/bundles/doublespark/js/saveButton.js';

    // CSS
    $GLOBALS['TL_CSS'][] = '/bundles/doublespark/css/wordCount.css';
    $GLOBALS['TL_CSS'][] = '/bundles/doublespark/css/saveButton.css';
}

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['ds_meta_imex'] = [
    'callback' => 'Doublespark\Doublespark\BackendModules\MetaImportExport'
];

$GLOBALS['BE_MOD']['system']['ds_local_assets'] = [
    'tables' => ['tl_ds_local_assets']
];

/**
 * Add box element
 */
$GLOBALS['TL_CTE']['texts']['ds_content_grid_start'] = 'Doublespark\Doublespark\Elements\ContentGridStartElement';
$GLOBALS['TL_CTE']['texts']['ds_content_grid_end']   = 'Doublespark\Doublespark\Elements\ContentGridEndElement';

/**
 * Mark elements as wrappers
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'ds_content_grid_start';
$GLOBALS['TL_WRAPPERS']['stop'][]  = 'ds_content_grid_end';

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily']['updateLocalAssets'] = array('Doublespark\Doublespark\Cron\DsAutomator', 'updateLocalAssets');