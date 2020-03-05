<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Backend JS
 */
if(TL_MODE == 'BE')
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
array_insert($GLOBALS['BE_MOD']['system'], 1, array
(
    'ds_meta_imex' => array
    (
        'callback'   => 'Doublespark\Doublespark\BackendModules\MetaImportExport'
    ),
    'ds_local_assets' => array
    (
        'tables' => array('tl_ds_local_assets')
    )
));

/**
 * Remove locale from URL
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Doublespark\Doublespark\Hooks\HookGeneratePage','addCanonicalTag');

/**
 * Add box element
 */
$GLOBALS['TL_CTE']['texts']['ds_content_grid_start'] = 'Doublespark\Doublespark\Elements\ContentGridStartElement';
$GLOBALS['TL_CTE']['texts']['ds_content_grid_end']   = 'Doublespark\Doublespark\Elements\ContentGridEndElement';

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily']['updateLocalAssets'] = array('Doublespark\Doublespark\Cron\DsAutomator', 'updateLocalAssets');