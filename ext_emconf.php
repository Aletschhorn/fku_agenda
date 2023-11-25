<?php

$EM_CONF[$_EXTKEY] = [
	'title' => 'FKU Agenda',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Daniel Widmer',
	'author_email' => 'daniel.widmer@fku.ch',
	'state' => 'stable',
	'clearCacheOnLoad' => 1,
	'version' => '7.3.0',
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.0-10.4.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];

/***********************************************
 * Version 5.0.0
 * -------------                    
 * Removed all birthday table, model, repository, ...
 * New navigation pills on all views
 * Layout variable to switch between default and FkuAktuell layout of ListMonthView
 * New model series and corresponding actions; allows to manage series "in parallel" zu events
 * Changed way to store related documents of events: not writing directly to DB but use FAL instead
 *
 * Version 5.0.1
 * -------------                    
 * Minor correction in layout ics.html (added END:VCALENDAR)
 *
 * Version 5.0.2
 * -------------                    
 * Bugfix of not adding file reference to new series
 *
 * Version 5.1.0
 * -------------                    
 * New field hideInList for event categories (allows to hide a category but leeave old events of this category)
 * To create .ics file, verification added if category is not hidden
 *
 * Version 5.1.1
 * -------------                    
 * Test version to tidy up the varity of Event variables that are not available in the database (e.g. eventStartDay)
 *
 * Version 5.2.0
 * -------------                    
 * Remove of some set... functions in Event model
 *
 * Version 5.2.1
 * -------------                    
 * Fixed bug to show multi-day events starting a day 1, 2, or 3 of the month on same day as single-day events at day 11, 21, or 31
 *
 * Version 5.2.2
 * -------------                    
 * Patch for problem that page is loaded twice, which leads to doubled copying of an event with copyAction
 *
 * Version 5.2.3
 * -------------                    
 * Additional detail for patch of version 5.2.2: set cookie value to 0 in editAction
 *
 * Version 5.2.4
 * -------------                    
 * Patch of version 5.2.2 solve sustainably by adding action copy in ext_localconf.php; commented new lines of versions 5.2.2 and 5.2.3
 *
 * Version 5.3.0
 * -------------                    
 * Store year and month of any agenda list in cookies
 *
 * Version 5.3.1
 * -------------                    
 * Pagination with more sophisticated check of year and month
 *
 * Version 5.3.2
 * -------------                    
 * Small corrections of month list in XS format: changes in template ListMonth and partial ListSmall
 *
 * Version 5.3.3
 * -------------                    
 * Corrections in TCA definitions to remove depreciated parameters
 *
 * Version 5.3.4
 * -------------                    
 * Only update of TYPO3 version dependency
 *
 * Version 6.0.0
 * -------------                    
 * Ready for Typo3 version 10
 * Many further updates, e.g. for Bootstrap package 4.5 and Glyphicons 2.4
 *
 * Version 6.0.1
 * -------------                    
 * Correction view helper WeekdayViewHelper: 2nd parameter of strftime to transfer to timestamp
 * Added definition of crdate and tstamp for Event in TCA to avoid error in IcalCommand
 *
 * Version 6.0.2
 * -------------                    
 * Correction in WeekdayViewHelper for creation of DateTime out of given day, month, year
 *
 * Version 6.0.3
 * -------------                    
 * composer.json added
 * Replaced twice ResourceFactory::getInstance() by GeneralUtility::makeInstance(ResourceFactory::class) in EventController
 *
 * Version 6.0.4
 * -------------                    
 * Bug fix in viewhelper IsNumber
 *
 * Version 7.0.0
 * -------------                    
 * Remove left-overs from beamer view and Losungen
 * Create separate plugins (in ext_localconf.php) and removed switchableControllerActions from pi_flexform
 * Define dependency injections with Service.yaml, remove Commands.php to define scheduler tasks
 *
 * Version 7.0.1
 * -------------                    
 * Remove debug comments in ListIndividualRows.html
 *
 * Version 7.0.2
 * -------------                    
 * Check variable $event in event controller action "ics"
 *
 * Version 7.0.3
 * -------------                    
 * Minor change in EventController to avoid errors with array "modified" in updateSeriesAction
 *
 *
 */
?>