<?php
defined('TYPO3_MODE') or die();

foreach (['event', 'room', 'resource', 'category', 'visibilitycategory', 'series'] as $table) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fkuagenda_domain_model_' . $table);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fkuagenda_domain_model_' . $table, 
	'EXT:fku_agenda/Resources/Private/Language/locallang_csh_tx_fkuagenda_domain_model_' . $table . '.xlf');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fku_agenda', 'Configuration/TypoScript', 'FKU Agenda');

?>