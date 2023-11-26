<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
	'ctrl' => [
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
		'enablecolumns' => [
			'disabled' => 'hidden'
		],
		'searchFields' => 'title,',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_room.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'hidden, title, title_short, title_tiny',
	],
	'types' => [
		'1' => ['showitem' => 'hidden, title,title_short,title_tiny'],
	],
	'palettes' => [],
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
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'title_short' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title_short',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'title_tiny' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_room.title_tiny',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
	],
];

?>