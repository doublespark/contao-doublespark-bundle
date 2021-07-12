<?php

/**
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] =  str_replace
(
	'{meta_legend}',
	'{canonical_legend},rel_canonical_url,strip_query_strings,disable_canonical;{meta_legend}',
	$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['rel_canonical_url'] = array
(
	'exclude'       => true,
	'inputType'     => 'text',
	'sql'           => "varchar(128) NOT NULL default ''",
	'eval'          => array('rgxp'=>'url', 'doNotCopy'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['strip_query_strings'] = array
(
    'exclude'       => true,
    'inputType'     => 'checkbox',
    'sql'           => "char(1) NOT NULL default ''",
    'eval'          => array('doNotCopy'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['disable_canonical'] = array
(
    'exclude'       => true,
    'inputType'     => 'checkbox',
    'sql'           => "char(1) NOT NULL default ''",
    'eval'          => array('doNotCopy'=>true, 'tl_class'=>'w50 clr')
);