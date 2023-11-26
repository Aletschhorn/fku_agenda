<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden'
		],
		'searchFields' => 'title,acronym,duration,details_pid',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_category.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, hide_in_list, title, acronym, duration, details_pid',
	],
	'types' => [
		'1' => ['showitem' => '--palette--;;hideOptions, title, acronym, duration, details_pid'],
	],
	'palettes' => [
		'hideOptions' => ['showitem' => 'hidden, hide_in_list'],
	],
	'columns' => [
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'title' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'acronym' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.acronym',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,required'
			],
		],
		'duration' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.duration',
			'config' => [
				'type' => 'input',
				'size' => 5,
				'eval' => 'int'
			],
		],
		'details_pid' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.details_pid',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'maxitems' => 1,
				'size' => 1,
				'sgguestOptions' => [
					'default' => [
						'searchWholePhrase' => 1
					],
					'pages' => [
						'searchCondition' => 'doktype = 1'
					]
				]
			]
		],
		'hide_in_list' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_category.hide_in_list',
			'config' => [
				'type' => 'check',
			],
		],
	],
];

?>