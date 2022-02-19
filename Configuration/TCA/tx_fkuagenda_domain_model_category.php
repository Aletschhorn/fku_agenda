<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,acronym,duration,details_pid',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_category.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, hide_in_list, title, acronym, duration, details_pid',
	),
	'types' => array(
		'1' => array('showitem' => '--palette--;;hideOptions, title, acronym, duration, details_pid, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'hideOptions' => array('showitem' => 'hidden, hide_in_list'),
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
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
			'label' => 'LLL:EXT:LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
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
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'acronym' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.acronym',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,required'
			),
		),
		'duration' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.duration',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'int'
			),
		),
		'details_pid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.details_pid',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'maxitems' => 1,
				'size' => 1,
				'sgguestOptions' => array(
					'default' => array(
						'searchWholePhrase' => 1
					),
					'pages' => array(
						'searchCondition' => 'doktype = 1'
					)
				)
			)
		),
		'hide_in_list' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.hide_in_list',
			'config' => array(
				'type' => 'check',
			),
		),
	),
);

?>