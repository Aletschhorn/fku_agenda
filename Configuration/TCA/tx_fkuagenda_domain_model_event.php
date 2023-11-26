<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event',
		'label' => 'description',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY event_start DESC',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',

		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'description,news_text,',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_event.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'hidden, description, event_start, event_end, all_day, link, related_documents, news_start, news_end, news_text, rooms, resources, category, visible',
	],
	'types' => [
		'1' => ['showitem' => 'hidden, --palette--;;eventdate, description, --palette--;;params, link, related_documents, --palette--;;news, rooms, resources, --div--;LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tab.series, series, --div--;LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tab.news, --palette--;;newsdate, news_text, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, --palette--;;access'],
	],
	'palettes' => [
		'eventdate' => ['showitem' => 'event_start, event_end, all_day'],
		'newsdate' => ['showitem' => 'news_start, news_end'],
		'params' => ['showitem' => 'category, visible'],
		'access' => ['showitem' => 'starttime, endtime'],
	],
	'columns' => [
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'starttime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			],
		],
		'endtime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			],
		],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ]
        ],
		'description' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim'
			],
		],
		'event_start' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.event_start',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,required',
				'checkbox' => 1,
				'default' => 0
			],
		],
		'event_end' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.event_end',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => 0
			],
		],
		'all_day' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.all_day',
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
		'link' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.link',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'related_documents' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.related_documents',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'related_documents', 
				[
					'appearance' => array('createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'),
					'foreign_match_fields' => array('fieldname' => 'related_documents', 'tablenames' => 'tx_fkuagenda_domain_model_event', 'table_local' => 'sys_file')
				]
			)
		],
		'news_start' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.news_start',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => 0
			],
		],
		'news_end' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.news_end',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => 0
			],
		],
		'news_text' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.news_text',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'rooms' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.rooms',
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
		'resources' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.resources',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_fkuagenda_domain_model_resource',
				'MM' => 'tx_fkuagenda_event_resource_mm',
				'size' => 5,
				'autoSizeMax' => 10,
				'maxitems' => 99,
				'multiple' => 0,
			],
		],
		'category' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.category',
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
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.visible',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkuagenda_domain_model_visibilitycategory',
				'minitems' => 0,
				'maxitems' => 1,
			],
		],
		'series' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_event.series',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['None', 0],
				],
				'foreign_table' => 'tx_fkuagenda_domain_model_series',
				'minitems' => 1,
				'maxitems' => 1,
			],
		],
	],
];

?>