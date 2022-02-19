<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Month',
	'Agenda Monthly List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Year',
	'Agenda Annual List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'News',
	'Agenda News List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Next',
	'Agenda Next Events'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Rooms',
	'Agenda Room Allocation'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Legend',
	'Agenda Category List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuAgenda',
	'Search',
	'Agenda Search Form'
);

// register flexforms
foreach (['month', 'year', 'news', 'next', 'rooms', 'legend', 'search'] as $plugin) {
	$pluginSignature = 'fkuagenda_'.$plugin;
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive'; 
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:fku_agenda/Configuration/FlexForms/flexform_'.$plugin.'.xml'); 
}

?>