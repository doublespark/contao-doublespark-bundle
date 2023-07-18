<?php

use Doublespark\Doublespark\Elements\BannerImageController;

$GLOBALS['TL_DCA']['tl_content']['palettes']['ds_content_grid_start'] = '{type_legend},type;{config_legend},ds_content_grid_columns;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['ds_content_grid_end']   = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes'][BannerImageController::TYPE] =
    '{type_legend},type;{source_legend},singleSRC,size,overwriteMeta,useOpenGraphImgTag;{protected_legend:hide},protected;{text_legend},addText;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'addText';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addText'] = 'text';

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_content_grid_columns'] = [
    'exclude'   => false,
    'inputType' => 'select',
    'options'   => [1,2,3,4,5,6,7,8,9,10],
    'eval'      => array('mandatory' => true, 'rgxp' => 'natural', 'tl_class'=>'clr'),
    'sql'       => "int(10) unsigned NOT NULL default 0"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['addText'] = array
(
    'inputType' => 'checkbox',
    'eval'      => array('submitOnChange'=>true),
    'sql'       => array('type' => 'boolean', 'default' => false)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['useOpenGraphImgTag'] = array
(
    'inputType' => 'checkbox',
    'eval'      => array('tl_class'=>'clr'),
    'sql'       => array('type' => 'boolean', 'default' => false)
);