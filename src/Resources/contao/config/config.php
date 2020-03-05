<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Doublespark 2016
 * @author     Jamie Devine <jamie.devine@doublespark.co.uk>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

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
    'meta_imex' => array
    (
        'callback'   => 'Doublespark\Doublespark\BackendModules\MetaImportExport'
    ),
    'local_assets' => array
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
$GLOBALS['TL_CTE']['links']['boxlink']            = 'Doublespark\Doublespark\Elements\ContentBoxLink';
$GLOBALS['TL_CTE']['media']['parallax_section']   = 'Doublespark\Doublespark\Elements\ParallaxSectionElement';
$GLOBALS['TL_CTE']['texts']['double_text']        = 'Doublespark\Doublespark\Elements\DoubleTextElement';
$GLOBALS['TL_CTE']['texts']['content_grid_start'] = 'Doublespark\Doublespark\Elements\ContentGridStartElement';
$GLOBALS['TL_CTE']['texts']['content_grid_end']   = 'Doublespark\Doublespark\Elements\ContentGridEndElement';

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily']['updateLocalAssets'] = array('Doublespark\Doublespark\Cron\DsAutomator', 'updateLocalAssets');