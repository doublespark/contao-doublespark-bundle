<?php

/**
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] =  str_replace
(
	'{meta_legend}',
	'{canonical_legend},rel_canonical_url;{meta_legend}',
	$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['rel_canonical_url'] = array
(
	'exclude'       => true,
	'inputType'     => 'text',
	'sql'           => "varchar(128) NOT NULL default ''",
	'eval'          => array('rgxp'=>'url', 'doNotCopy'=>true, 'tl_class'=>'w50 clr')
);