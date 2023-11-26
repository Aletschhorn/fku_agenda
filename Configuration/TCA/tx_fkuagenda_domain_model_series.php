<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series',
		'label' => 'description',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY date_start DESC',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',

		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden'
		],
		'searchFields' => 'description,news_text,',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_series.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'hidden, description, date_start, date_end, interval, weekday_weekly, weekday_monthly, weekday_option, all_day, link, related_documents, news_option, news_text, rooms, resources, category, visible',
	],
	'types' => [
		'1' => ['showitem' => 'hidden, --palette--;;eventdate, --palette--;;intervaldetails, description, --palette--;;eventtime, --palette--;;params, link, related_documents, --palette--;;news, rooms, resources, --div--;LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tab.news, --palette--;;newsdate'],
	],
	'palettes' => [
		'eventdate' => ['showitem' => 'date_start, date_end'],
		'eventtime' => ['showitem' => 'all_day, time_start, time_end'],
		'newsdate' => ['showitem' => 'news_option, news_text'],
		'params' => ['showitem' => 'category, visible'],
		'intervaldetails' => ['showitem' => 'interval, weekday_weekly, weekday_option, weekday_monthly'],
	],
	'columns' => [
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'description' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim'
			],
		],
		'date_start' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.date_start',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'date,required',
				'checkbox' => 1,
			],
		],
		'date_end' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.date_end',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'date',
				'checkbox' => 1,
			],
		],
		'time_start' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.time_start',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'time',
				'checkbox' => 1,
			],
		],
		'time_end' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.time_end',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'time',
				'checkbox' => 1,
			],
		],
		'all_day' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.all_day',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['As defined', 0],
					['All day', 1],
					['In the evening', 2],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'interval' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.interval',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['Weekly', 0],
					['Monthly', 1],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'weekday_weekly' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_weekly',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['Monday', 1],
					['Tuesday', 2],
					['Wednesday', 3],
					['Thursday', 4],
					['Friday', 5],
					['Saturday', 6],
					['Sunday', 7],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'weekday_monthly' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_monthly',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['Monday', 1],
					['Tuesday', 2],
					['Wednesday', 3],
					['Thursday', 4],
					['Friday', 5],
					['Saturday', 6],
					['Sunday', 7],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'weekday_option' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_option',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['First', 1],
					['Second', 2],
					['Third', 3],
					['Fourth', 4],
					['Last', 5],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'link' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.link',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'related_documents' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.related_documents',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'related_documents', 
				[
					'appearance' => array('createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'),
					'foreign_match_fields' => array('fieldname' => 'related_documents', 'tablenames' => 'tx_fkuagenda_domain_model_series', 'table_local' => 'sys_file')
				]
			)
                
		],
		'news_option' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.news_option',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['Never', 0],
					['1 day', 1],
					['2 day', 2],
					['3 day', 3],
					['4 day', 4],
					['5 day', 5],
					['1 week', 6],
					['2 weeks', 7],
					['1 month', 8],
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'news_text' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.news_text',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'rooms' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.rooms',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_fkuagenda_domain_model_room',
				'MM' => 'tx_fkuagenda_event_room_mm',
				'size' => 5,
				'autoSizeMax' => 10,
				'maxitems' => 99,
				'multiple' => 0,
			],
		],
		'category' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.category',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkuagenda_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
			],
		],
		'visible' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.visible',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkuagenda_domain_model_visibilitycategory',
				'minitems' => 0,
				'maxitems' => 1,
			],
		],
	],
];

?>