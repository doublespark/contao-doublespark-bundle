<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Table tl_ds_local_assets
 */
$GLOBALS['TL_DCA']['tl_ds_local_assets'] = array
(

	// Config
	'config' => array
	(
		'dataContainer' => 'Table',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
        'onsubmit_callback' => array
        (
            array('tl_ds_local_assets', 'updateLocalAssets')
        ),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'flag'                    => 1,
			'fields'                  => array('url'),
			'panelLayout'             => 'filter;sort,search,limit',
			'disableGrouping'         => true
		),
		'label' => array
		(
			'fields'                  => array('url'),
			'format'                  => '%s',
            'label_callback'          => array('tl_ds_local_assets', 'getListLabel')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => 'url',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ds_local_assets']['url'],
			'search'                  => true,
			'inputType'               => 'text',
			'sql'                     => "varchar(155) NOT NULL default ''",
			'eval'                    => array('unique'=>true,'rgxp' =>'url')
		),
        'last_updated' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
	)
);

/**
 * Class tl_ds_local_assets
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_ds_local_assets extends Backend
{
    /**
     * Fetch the local assets now
     */
    public function updateLocalAssets()
    {
        $dsAutomator = new \Doublespark\Doublespark\Cron\DsAutomator();
        $dsAutomator->updateLocalAssets();
    }

    /**
     * Generate label for the Contao backend list
     * @param  Array $arrData
     * @return String
     */
    public function getListLabel($arrData)
    {
        if($arrData['last_updated'] > 0)
        {
            $updated = 'Updated: '.date('d/m/Y H:i', $arrData['last_updated']);
        }
        else
        {
            $updated = 'Updated: Never';
        }

        $label = '<span style="color:#CCC;">['.$updated.']</span> '.$arrData['url'];

        return $label;
    }
}