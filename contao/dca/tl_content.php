<?php

use Doublespark\ContaoDoublesparkBundle\Elements\BannerImageElementController;
use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridStartElementController;
use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridEndElementController;

$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentGridStartElementController::TYPE] = '{type_legend},type;{config_legend},ds_gridColumns;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentGridendElementController::TYPE]   = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes'][BannerImageElementController::TYPE] =
    '{type_legend},type;{source_legend},singleSRC,size,overwriteMeta,ds_useOpenGraphImgTag;{protected_legend:hide},protected;{text_legend},ds_addText;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'ds_addText';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['ds_addText'] = 'text';

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_gridColumns'] = [
    'exclude'   => false,
    'inputType' => 'select',
    'options'   => [1,2,3,4,5,6,7,8,9,10],
    'eval'      => array('mandatory' => true, 'rgxp' => 'natural', 'tl_class'=>'clr'),
    'sql'       => "int(10) unsigned NOT NULL default 0"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_addText'] = array
(
    'inputType' => 'checkbox',
    'eval'      => array('submitOnChange'=>true),
    'sql'       => array('type' => 'boolean', 'default' => false)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_useOpenGraphImgTag'] = array
(
    'inputType' => 'checkbox',
    'eval'      => array('tl_class'=>'clr'),
    'sql'       => array('type' => 'boolean', 'default' => false)
);