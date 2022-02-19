<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
	'ctrl' => array(
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
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'description,news_text,',
		'iconfile' => 'EXT:fku_agenda/Resources/Public/Icons/tx_fkuagenda_domain_model_series.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, description, date_start, date_end, interval, weekday_weekly, weekday_monthly, weekday_option, all_day, link, related_documents, news_option, news_text, rooms, resources, category, visible',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, --palette--;;eventdate, --palette--;;intervaldetails, description, --palette--;;eventtime, --palette--;;params, link, related_documents, --palette--;;news, rooms, resources, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, --palette--;;access, --div--;LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tab.news, --palette--;;newsdate'),
	),
	'palettes' => array(
		'eventdate' => array('showitem' => 'date_start, date_end'),
		'eventtime' => array('showitem' => 'all_day, time_start, time_end'),
		'newsdate' => array('showitem' => 'news_option, news_text'),
		'params' => array('showitem' => 'category, visible'),
		'access' => array('showitem' => 'starttime, endtime'),
		'intervaldetails' => array('showitem' => 'interval, weekday_weekly, weekday_option, weekday_monthly'),
	),
	'columns' => array(
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
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
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
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim'
			),
		),
		'date_start' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.date_start',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'date,required',
				'checkbox' => 1,
			),
		),
		'date_end' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.date_end',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'date',
				'checkbox' => 1,
			),
		),
		'time_start' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.time_start',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'time',
				'checkbox' => 1,
			),
		),
		'time_end' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.time_end',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'time',
				'checkbox' => 1,
			),
		),
		'all_day' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.all_day',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('As defined', 0),
					array('All day', 1),
					array('In the evening', 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'interval' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.interval',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Weekly', 0),
					array('Monthly', 1),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'weekday_weekly' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_weekly',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Monday', 1),
					array('Tuesday', 2),
					array('Wednesday', 3),
					array('Thursday', 4),
					array('Friday', 5),
					array('Saturday', 6),
					array('Sunday', 7),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'weekday_monthly' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_monthly',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Monday', 1),
					array('Tuesday', 2),
					array('Wednesday', 3),
					array('Thursday', 4),
					array('Friday', 5),
					array('Saturday', 6),
					array('Sunday', 7),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'weekday_option' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.weekday_option',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('First', 1),
					array('Second', 2),
					array('Third', 3),
					array('Fourth', 4),
					array('Last', 5),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'link' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.link',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'related_documents' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.related_documents',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'related_documents', 
				array(
					'appearance' => array('createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference'),
					'foreign_match_fields' => array('fieldname' => 'related_documents', 'tablenames' => 'tx_fkuagenda_domain_model_series', 'table_local' => 'sys_file')
				)
			)
                
		),
		'news_option' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.news_option',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Never', 0),
					array('1 day', 1),
					array('2 day', 2),
					array('3 day', 3),
					array('4 day', 4),
					array('5 day', 5),
					array('1 week', 6),
					array('2 weeks', 7),
					array('1 month', 8),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'news_text' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.news_text',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'rooms' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.rooms',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_fkuagenda_domain_model_room',
				'MM' => 'tx_fkuagenda_event_room_mm',
				'size' => 5,
				'autoSizeMax' => 10,
				'maxitems' => 99,
				'multiple' => 0,
			),
		),
		'category' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.category',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkuagenda_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'visible' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:fku_agenda/Resources/Private/Language/locallang_db.xlf:tx_fkuagenda_domain_model_series.visible',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkuagenda_domain_model_visibilitycategory',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

?>