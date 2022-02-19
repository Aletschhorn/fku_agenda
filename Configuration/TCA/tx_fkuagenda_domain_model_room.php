<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_room.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, title, title_short, title_tiny',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, title,title_short,title_tiny,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
	),
	'columns' => array(
		't3ver_label' => array(
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'title_short' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title_short',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'title_tiny' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title_tiny',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
	),
);

?>