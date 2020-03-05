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
$GLOBALS['TL_DCA']['tl_content']['palettes']['content_grid_start'] = '{type_legend},type;{config_legend},ds_content_grid_columns;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['content_grid_end']   = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_content_grid_columns'] = [
    'exclude'   => false,
    'inputType' => 'select',
    'options'   => [1,2,3,4,5,6,7,8,9,10],
    'eval'      => array('mandatory' => true, 'rgxp' => 'natural', 'tl_class'=>'clr'),
    'sql'       => "int(10) unsigned NOT NULL default 0"
];