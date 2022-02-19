<?php
use FKU\FkuAgenda\Controller\EventController;

defined('TYPO3_MODE') || die();

(static function() {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Month',
		[EventController::class => 'listMonth, search, new, create, createSeries, edit, editSeries, update, updateSeries, delete, deleteSeries, copy'],
		[EventController::class => 'search, create, createSeries, edit, editSeries, update, updateSeries, delete, deleteSeries, copy']
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Year',
		[EventController::class => 'listYear, listMonth'],
		[]
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'News',
		[EventController::class => 'listNews'],
		[]
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Next',
		[EventController::class => 'listNext'],
		[]
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Rooms',
		[EventController::class => 'listRoomAllocation'],
		[]
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Legend',
		[EventController::class => 'listCategories'],
		[]
	);
	
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Search',
		[EventController::class => 'search, listMonth'],
		[EventController::class => 'search']
	);
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuAgenda',
		'Ics',
		[EventController::class => 'ics'],
		[EventController::class => 'ics']
	);
})();

?>