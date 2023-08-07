<?php

use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridStartElementController;
use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridEndElementController;

$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentGridStartElementController::TYPE] = '{type_legend},type;{config_legend},ds_gridColumns;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentGridendElementController::TYPE]   = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['ds_gridColumns'] = [
    'exclude'   => false,
    'inputType' => 'select',
    'options'   => [1,2,3,4,5,6,7,8,9,10],
    'eval'      => array('mandatory' => true, 'rgxp' => 'natural', 'tl_class'=>'clr'),
    'sql'       => "int(10) unsigned NOT NULL default 0"
];