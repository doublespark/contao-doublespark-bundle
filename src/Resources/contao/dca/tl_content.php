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
$GLOBALS['TL_DCA']['tl_content']['palettes']['boxlink']          = '{type_legend},type,headline,boxlink_subheading;{link_legend},url,target,linkTitle,embed,titleText,rel;{source_legend},singleSRC,imageUrl;{text_legend},text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['parallax_section'] = '{type_legend},type,headline;{source_legend},singleSRC,imageUrl;{text_legend},left_text,right_text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['double_text']      = '{type_legend},type;{text_legend},left_text,right_text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['boxlink_subheading'] = array(
    'label'     => array('Sub-heading','The sub-heading of the box'),
    'exclude'   => false,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false,  'tl_class'=>'clr'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['right_text'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['right_text'],
    'search'                  => true,
    'inputType'               => 'textarea',
    'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true),
    'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['left_text'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['left_text'],
    'search'                  => true,
    'inputType'               => 'textarea',
    'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true),
    'sql'                     => "mediumtext NULL"
);