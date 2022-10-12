<?php
namespace FKU\FkuAgenda\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Widmer <daniel.widmer@fku.ch>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use FKU\FkuAgenda\Domain\Model\FileReference;
use FKU\FkuAgenda\Domain\Repository\EventRepository;
use FKU\FkuAgenda\Domain\Repository\RoomRepository;
use FKU\FkuAgenda\Domain\Repository\ResourceRepository;
use FKU\FkuAgenda\Domain\Repository\CategoryRepository;
use FKU\FkuAgenda\Domain\Repository\SeriesRepository;
use FKU\FkuAgenda\Domain\Repository\FileReferenceRepository;

/**
 *
 * @package tx_fkuagenda
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

class EventController extends ActionController {

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

	/**
	 * @var EventRepository
	 */
	protected $eventRepository;

	/**
	 * @var RoomRepository
	 */
	protected $roomRepository;

	/**
	 * @var ResourceRepository
	 */
	protected $resourceRepository;

	/**
	 * @var CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @var SeriesRepository
	 */
	protected $seriesRepository;

	/**
	 * @var FileReferenceRepository
	 */
	protected $fileReferenceRepository;

	/**
	 * @param PersistenceManager $persistenceManager
	 * @param EventRepository $eventRepository
	 * @param RoomRepository $roomRepository
	 * @param ResourceRepository $resourceRepository
	 * @param CategoryRepository $categoryRepository
	 * @param SeriesRepository $seriesRepository
	 * @param FileReferenceRepository $fileReferenceRepository
	 */
	public function __construct(
			PersistenceManager $persistenceManager,
			EventRepository $eventRepository,
			RoomRepository $roomRepository,
			ResourceRepository $resourceRepository,
			CategoryRepository $categoryRepository,
			SeriesRepository $seriesRepository,
			FileReferenceRepository $fileReferenceRepository
		) {
		$this->persistenceManager = $persistenceManager;
		$this->eventRepository = $eventRepository;
		$this->roomRepository = $roomRepository;
		$this->resourceRepository = $resourceRepository;
		$this->categoryRepository = $categoryRepository;
		$this->seriesRepository = $seriesRepository;
		$this->fileReferenceRepository = $fileReferenceRepository;
	}
	
	/**
	 * @var Array monatsnamen
	 */
	protected $monatsnamen = ['','Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];

	/**
	 * @var Array monatsnamenKurz
	 */
	protected $monatsnamenKurz = ['','Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'];

	/**
	 * @var Array wtagnamen
	 */
	protected $wtagnamen = ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'];

	/**
	 * @var Array 
	 */
	protected $weekdays = [1 => 'Montag', 2 => 'Dienstag', 3 => 'Mittwoch', 4 => 'Donnerstag', 5 => 'Freitag', 6 => 'Samstag', 7 => 'Sonntag'];

	/**
	 * @var Array withinMonth
	 */
	protected $withinMonth = [1 => 'ersten', 2 => 'zweiten', 3 => 'dritten', 4 => 'vierten', 5 => 'letzten'];

	/**
	 * @var Array newsAdvance
	 */
	protected $newsAdvance = [0 => 'nie', 1 => '1 Tag', 2 => '2 Tage', 3 => '3 Tage', 4 => '4 Tage', 5 => '5 Tage', 6 => '1 Woche', 7 => '2 Wochen', 8 => '1 Monat'];

	/**
	 * action listMonth
	 *
	 * @return void
	 */
	public function listMonthAction() {
		
		$selection = $this->getYearAndMonth();
		
		if ($this->request->hasArgument('layout')) { 
			$layout = $this->request->getArgument('layout'); 
		} else {
			$layout = $this->settings['layout']; 
		}
		if ($layout != 'FkuAktuell') {
			$layout = 'Default';
		}

		$visibility = explode(',',$this->settings['showVisibility']);
		$categoriesAll = $this->settings['showAllCategories'];
		$categories = explode(',',$this->settings['showCategory']);
		
		$categoryRequest = NULL;
		if ($this->request->hasArgument('category')) { 
			$categoryRequest = trim($this->request->getArgument('category'));
			$categoryRequestArray = explode(',',$categoryRequest);
			if (strlen($categoryRequest) and count($categoryRequestArray)>0) {
				if ($categoriesAll) {
					$categories = $categoryRequestArray;
					$categoriesAll = 0;
				} else {
					$categoriesNew = array ();
					foreach ($categoryRequestArray as $cat) {
						if (in_array($cat,$categories)) {
							$categoriesNew[] = $cat;
						}
					}
					$categories = $categoriesNew;
				}
				$limitation = $this->categoryRepository->findByUids($categories);
			}
		}

		$events = $this->eventRepository->findByMonth($selection['month'], $selection['year'], $visibility, $categoriesAll, $categories);
		if ($this->settings['preacher']) {
			$events = $this->removePreacher($events);
		}

		$this->view->assignMultiple(array(
			'events' => $events,
			'month' => $selection['month'],
			'year' => $selection['year'],
			'layout' => $layout,
			'pagination' => $this->getPagination ($selection['month'], $selection['year'], 2, 5, $layout, $categoryRequest),
			'monatsnamen' => $this->monatsnamen,
			'settings' => $this->settings,
			'limitation' => $limitation,
		));
	}

	/**
	 * action listMonthEdit
	 *
	 * @return void
	 */
	public function listMonthEditAction() {
		
		$selection = $this->getYearAndMonth();

		$events = $this->eventRepository->findByMonth($selection['month'], $selection['year'], explode(',',$this->settings['showVisibility']), $this->settings['showAllCategories'], explode(',',$this->settings['showCategory']));
		$this->view->assignMultiple(array(
			'events' => $events,
			'month' => $selection['month'],
			'year' => $selection['year'],
			'monatsnamen' => $this->monatsnamen,
			'pagination' => $this->getPagination ($selection['month'], $selection['year'], 2, 5),
			'settings' => $this->settings,
		));
	}

	/**
	 * action listYear
	 *
	 * @return void
	 */
	public function listYearAction() {

		$selection = $this->getYearAndMonth();
		$year = $selection['year'];

		$nextYear = $year+1;
		if ($nextYear > date('Y')+2) {
			$nextYear = 0;
		}
		$prevYear = $year-1;
		if ($prevYear < 2013) {
			$prevYear = 0;
		}

		$numberOfDaysFeb = date ('t', mktime(0,0,0,2,1,$year));
		$monthData = array (
			1 => array ('number' => 1, 'name' => 'Januar', 'days' => 31),
			2 => array ('number' => 2, 'name' => 'Februar', 'days' => $numberOfDaysFeb),
			3 => array ('number' => 3, 'name' => 'März', 'days' => 31),
			4 => array ('number' => 4, 'name' => 'April', 'days' => 30),
			5 => array ('number' => 5, 'name' => 'Mai', 'days' => 31),
			6 => array ('number' => 6, 'name' => 'Juni', 'days' => 30),
			7 => array ('number' => 7, 'name' => 'Juli', 'days' => 31),
			8 => array ('number' => 8, 'name' => 'August', 'days' => 31),
			9 => array ('number' => 9, 'name' => 'September', 'days' => 30),
			10 => array ('number' => 10, 'name' => 'Oktober', 'days' => 31),
			11 => array ('number' => 11, 'name' => 'November', 'days' => 30),
			12 => array ('number' => 12, 'name' => 'Dezember', 'days' => 31)
		);
		$dayList = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);

		$events = $this->eventRepository->findByYear($year, explode(',',$this->settings['showVisibility']));
		$this->view->assignMultiple(array(
			'events' => $events,
			'year' => $year,
			'prevView' => array ('year' => $prevYear),
			'nextView' => array ('year' => $nextYear),
			'monthData' => $monthData,
			'dayList' => $dayList,
			'settings' => $this->settings,
		));
	}

	/**
	 * action listCategories
	 *
	 * @return void
	 */
	public function listCategoriesAction() {
		
		if ($this->settings['showAllCategories']) {
			$categories = $this->categoryRepository->findForList();
		} else {
			$categories = $this->categoryRepository->findByUids(explode(',',$this->settings['showCategory']));
		}
		$this->view->assignMultiple(array(
			'categories' => $categories,
			'settings' => $this->settings,
		));
	}

	/**
	 * action listNext
	 *
	 * @return void
	 */
	public function listNextAction() {
		
		$events = $this->eventRepository->findNext(intval($this->settings['limitation']), explode(',',$this->settings['showVisibility']), $this->settings['showAllCategories'], explode(',',$this->settings['showCategory']));
		
		$this->view->assignMultiple(array(
			'monatsnamen' => $this->monatsnamen,
			'events' => $events,
			'settings' => $this->settings,
		));
	}

	/**
	 * action listNews
	 *
	 * @return void
	 */
	public function listNewsAction() {
		
		$events = $this->eventRepository->findNews(explode(',',$this->settings['showVisibility']), $this->settings['showAllCategories'], explode(',',$this->settings['showCategory']), intval($this->settings['limitation']));
		
		$this->view->assignMultiple(array(
			'monatsnamen' => $this->monatsnamen,
			'events' => $events,
			'settings' => $this->settings,
		));
	}

	/**
	 * action listRoomAllocation
	 *
	 * @return void
	 */
	public function listRoomAllocationAction() {
		
		$selection = $this->getYearAndMonth();
		$month = $selection['month'];
		$year = $selection['year'];

		$numberOfDays = date('t', mktime(0,0,0,$month,1,$year));

		$prevMonth = $month-1;
		$prevYear = $year;
		if ($prevMonth < 1) {
			$prevMonth = 12;
			$prevYear = $year-1;
		}

		$nextMonth = $month+1;
		$nextYear = $year;
		if ($nextMonth > 12) {
			$nextMonth = 1;
			$nextYear = $year+1;
		}
		
		$dayList = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);

		$rooms = $this->roomRepository->findAll();

		$events = $this->eventRepository->findByMonth($month, $year, explode(',',$this->settings['showVisibility']), $this->settings['showAllCategories'], explode(',',$this->settings['showCategory']));
		$this->view->assignMultiple(array(
			'rooms' => $rooms,
			'events' => $events,
			'month' => $month,
			'year' => $year,
			'numberOfDays' => $numberOfDays,
			'dayList' => $dayList,
			'prevView' => array ('month' => $prevMonth, 'year' => $prevYear),
			'nextView' => array ('month' => $nextMonth, 'year' => $nextYear),
			'monatsnamen' => $this->monatsnamen,
			'pagination' => $this->getPagination ($month, $year, 2, 5),
			'settings' => $this->settings,
		));
	}

	/**
	 * action search
	 *
	 * @return void
	 */
	public function searchAction() {
		
		$error = 0;
		$back = 'listMonth';
		$sent = 0;
		$contains = 0;
		$expression = '';
		$category = 0;
		$daterangeStart = mktime(0,0,0,1,1,date('Y'));
		$daterangeEnd = mktime(0,0,0,12,31,date('Y'));		
		if ($this->request->hasArgument('back')) { $back = trim($this->request->getArgument('back')); }
		if ($this->request->hasArgument('sent')) { $sent = intval($this->request->getArgument('sent')); }
		if ($this->request->hasArgument('contains')) { $contains = intval($this->request->getArgument('contains')); }
		if ($this->request->hasArgument('expression')) { $expression = trim($this->request->getArgument('expression')); }
		if ($this->request->hasArgument('category')) { $category = intval($this->request->getArgument('category')); }
		if ($this->request->hasArgument('daterangeStart')) { 
			$entry = trim($this->request->getArgument('daterangeStart'));
			$part = explode('.',$entry);
			if (sizeof($part) == 3) {
				$date = mktime(0,0,0,$part[1],$part[0],$part[2]);
				if ($date) { $daterangeStart = $date; }
			}
		}
		if ($this->request->hasArgument('daterangeEnd')) { 
			$entry = trim($this->request->getArgument('daterangeEnd'));
			$part = explode('.',$entry);
			if (sizeof($part) == 3) {
				$date = mktime(23,59,59,$part[1],$part[0],$part[2]);
				if ($date) { $daterangeEnd = $date; }
			}
		}
		
		$visibility = explode(',',$this->settings['showVisibility']);
		$categoriesAll = $this->settings['showAllCategories'];
		$categories = explode(',',$this->settings['showCategory']);

		$filter = array(
			'contains' => $contains,
			'expression' => $expression,
			'category' => $category,
			'daterangeStart' => date('d.m.Y',$daterangeStart),
			'daterangeEnd' => date('d.m.Y',$daterangeEnd),
		);
		
		if ($expression or $category) {
			$events = $this->eventRepository->search($expression, $contains, $category, $daterangeStart, $daterangeEnd, $visibility, $categoriesAll, $categories);
		} else {
			$error = 1;
		}
		
		if ($categoriesAll) {
			$categories = $this->categoryRepository->findForList();
		} else {
			$categories = $this->categoryRepository->findByUids($categories);
		}
		
		$this->view->assignMultiple(array(
			'filter' => $filter,
			'categories' => $categories,
			'events' => $events,
			'sent' => $sent,
			'back' => $back,
			'error' => $error,
			'settings' => $this->settings,
		));
	}
	
	/**
	 * action new
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("event")
	 * @return void
	 */
	public function newAction(\FKU\FkuAgenda\Domain\Model\Event $event = NULL) {
		
		if (! is_object($event)) {
			$event = new \FKU\FkuAgenda\Domain\Model\Event();
		}
		
		$rooms = $this->roomRepository->findAll();
		$resources = $this->resourceRepository->findAll();
		$categories = $this->categoryRepository->findForList();
		
		$this->view->assignMultiple(array(
			'rooms' => $rooms,
			'resources' => $resources,
			'categories' => $categories,
			'event' => $event,
		));
	}

	/**
	 * action newSeries
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("series")
	 * @return void
	 */
	public function newSeriesAction(\FKU\FkuAgenda\Domain\Model\Series $series = NULL) {
		
		if (! is_object($series)) {
			$series = new \FKU\FkuAgenda\Domain\Model\Series();
		}
		
		$rooms = $this->roomRepository->findAll();
		$categories = $this->categoryRepository->findForList();
		
		$this->view->assignMultiple(array(
			'series' => $series,
			'rooms' => $rooms,
			'categories' => $categories,
			'weekdays' => $this->weekdays,
			'withinMonth' => $this->withinMonth,
			'newsAdvance' => $this->newsAdvance,
		));
	}

	/**
	* initializeCreateAction
	*
	* @return void
	*/
	public function initializeCreateAction() {
		if (isset($this->arguments['event'])) {
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		}
	}

	/**
	 * action create
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return void
	 */
	public function createAction(\FKU\FkuAgenda\Domain\Model\Event $event) {

		// write eventStart, eventEnd, newsStart and newsEnd values
		$event = $this->getDateTimeEntries($event);
		
		// upload and assign new file
		$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
		$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
		if (count($_FILES['tx_fkuagenda_month']['error'])) {
			foreach ($_FILES['tx_fkuagenda_month']['error'] as $fileId => $error) {
				if ($error == UPLOAD_ERR_OK) {
					
					// upload file
					$fileStoreName = $_FILES['tx_fkuagenda_month']['name'][$fileId];
					$fileTempName = $_FILES['tx_fkuagenda_month']['tmp_name'][$fileId];
					$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
					$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$event->addRelatedFile($fileRef);
				}
			}
		}

		// write to database
		$this->eventRepository->add($event);
		$this->addFlashMessage('Der Anlass wurde eingetragen.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => $event->getEventStart()->format('n'),'year' => $event->getEventStart()->format('Y')));
	}

	/**
	* initializeCreateSeriesAction
	*
	* @return void
	*/
	public function initializeCreateSeriesAction() {
		if (isset($this->arguments['series'])) {
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('dateStart')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('dateEnd')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('timeStart')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('timeEnd')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		}
	}

	/**
	 * action createSeries
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @return void
	 */
	public function createSeriesAction(\FKU\FkuAgenda\Domain\Model\Series $series) {
		if ($series->getDateStart() and $series->getDateEnd()) {
			$timezone = new \DateTimeZone('Europe/Zurich');
			$start = strtotime($series->getDateStart()->format('j F Y'));
			$end = strtotime($series->getDateEnd()->format('j F Y'));
			$dates = $this->getSeriesDates($start, $end, $series->getInterval(), $series->getWeekdayWeekly(), $series->getWeekdayMonthly(), $series->getWeekdayOption());
		}

		if (count($dates) > 0) {
			// upload and assign new file
			$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
			$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
			if (count($_FILES['tx_fkuagenda_month']['error'])) {
				foreach ($_FILES['tx_fkuagenda_month']['error'] as $fileId => $error) {
					if ($error == UPLOAD_ERR_OK and substr($_FILES['tx_fkuagenda_month']['name'][$fileId],-4) != '.php') {
						
						// upload file
						$fileStoreName = $_FILES['tx_fkuagenda_month']['name'][$fileId];
						$fileTempName = $_FILES['tx_fkuagenda_month']['tmp_name'][$fileId];
						$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
						$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
						$fileRef->setFile($fileObject);
						$series->addRelatedDocument($fileRef);
					}
				}
			}
			
			$this->seriesRepository->add($series);
	
			// create master event which will later be cloned multiple times
			$masterEvent = new \FKU\FkuAgenda\Domain\Model\Event();
			$masterEvent->setDescription($series->getDescription());
			$masterEvent->setAllDay($series->getAllDay());
			$masterEvent->setLink($series->getLink());
			$masterEvent->setCategory($series->getCategory());
			$masterEvent->setVisible($series->getVisible());
			$masterEvent->setNewsText($series->getNewsText());
			$masterEvent->setSeries($series);
					
			// Create an event per valid date
			$datesMessage = [];
			foreach ($dates as $eventDate) {
				$newEvent = clone $masterEvent;
				
				// Set date and time
				$this->getEventDates($series, $newEvent, $eventDate);
			
				// Define news information
				$this->getNewsDates($series, $newEvent);
			
				// Set rooms
				$newEvent->setRooms(new ObjectStorage);
				foreach ($series->getRooms() as $room) {
					$newEvent->addRoom($room);
				}

				// Create file references
				if ($fileObject) {
					$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$newEvent->setRelatedDocuments(new ObjectStorage());
					$newEvent->addRelatedDocument($fileRef);
				}
				
				// Store event in database
				$this->eventRepository->add($newEvent);
				$this->persistenceManager->persistAll();
				$eventId = (int)$newEvent->getUid();

				// Finalize single event creation
				unset($newEvent);
				$datesMessage[] = date('d.m.Y',$eventDate);
			}
		}

		if (count($datesMessage) > 0) {
			$this->addFlashMessage('Anlässe an folgenden Daten wurden erstellt: '.implode(', ',$datesMessage),'Anlass-Serie erstellt',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		} else {
			$this->addFlashMessage('Es konnten keine Anlässe erstellt werden, da es zwischen Anfangs- und Enddatum der Serie kein passendes Anlassdatum gibt.','Problem',\TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
			$dates[0] = time();
		}
		
		$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => date('n',$dates[0]),'year' => date('Y',$dates[0])));
	}

	/**
	* initializeEditAction
	*
	* @return void
	*/
	public function initializEditAction() {
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
	}

	/**
	 * action edit
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return void
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("event")
	 */
	public function editAction(\FKU\FkuAgenda\Domain\Model\Event $event) {

		$rooms = $this->roomRepository->findAll();
		$resources = $this->resourceRepository->findAll();
		$categories = $this->categoryRepository->findForList();		
		
		$this->view->assignMultiple(array(
			'event' => $event,
			'rooms' => $rooms,
			'resources' => $resources,
			'categories' => $categories,
		));
	}

	/**
	* initializeUpdateAction
	*
	* @return void
	*/
	public function initializeUpdateAction() {
		if (isset($this->arguments['event'])) {
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('eventEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartDate')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsStartTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['event']->getPropertyMappingConfiguration()->forProperty('newsEndTime')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		}
	}

	/**
	 * action update
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return void
	 */
	public function updateAction(\FKU\FkuAgenda\Domain\Model\Event $event) {
		// write eventStart, eventEnd, newsStart and newsEnd values
		$event = $this->getDateTimeEntries($event);

		// upload and assign new file
		$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
		$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
		$numberOfFiles = sizeof($event->getRelatedDocuments());
		if (count($_FILES['tx_fkuagenda_month']['error'])) {
			foreach ($_FILES['tx_fkuagenda_month']['error'] as $fileId => $error) {
				if ($error == UPLOAD_ERR_OK) {
					
					// upload file
					$fileStoreName = $_FILES['tx_fkuagenda_month']['name'][$fileId];
					$fileTempName = $_FILES['tx_fkuagenda_month']['tmp_name'][$fileId];
					$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
					$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$event->addRelatedDocument($fileRef);
				}
			}
		}
		
		// unlink (not delete) relation to files
		if ($this->request->hasArgument('delDocument')) {
			$delFiles = $this->request->getArgument('delDocument');
			if (sizeof($delFiles) > 0) {
				foreach ($delFiles as $fileId => $delete) {
					if ($delete) {
						// delete relation
						$fileRef = $this->fileReferenceRepository->findByUid($fileId);
						$event->removeRelatedDocument($fileRef);
						$this->fileReferenceRepository->remove($fileRef);
					}
				}
			}
		}

		// write to database
		$this->eventRepository->update($event);
		$this->addFlashMessage('Die Anlass-Daten wurden gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => $event->getEventStart()->format('n'),'year' => $event->getEventStart()->format('Y')));
	}

	/**
	 * action editSeries
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @return void
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("series")
	 */
	public function editSeriesAction(\FKU\FkuAgenda\Domain\Model\Series $series) {

		$events = $this->eventRepository->findPerSeries($series);
		$rooms = $this->roomRepository->findAll();
		$resources = $this->resourceRepository->findAll();
		$categories = $this->categoryRepository->findForList();
		if ($this->request->hasArgument('backEvent')) {
			$backEvent = $this->request->getArgument('backEvent');
		}
		
		$this->view->assignMultiple(array(
			'series' => $series,
			'events' => $events,
			'rooms' => $rooms,
			'categories' => $categories,
			'backEvent' => $backEvent,
			'weekdays' => $this->weekdays,
			'withinMonth' => $this->withinMonth,
			'newsAdvance' => $this->newsAdvance,
		));
	}

	/**
	* initializeUpdateSeriesAction
	*
	* @return void
	*/
	public function initializeUpdateSeriesAction() {
		if (isset($this->arguments['series'])) {
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('dateStart')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('dateEnd')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('timeStart')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
			$this->arguments['series']->getPropertyMappingConfiguration()->forProperty('timeEnd')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'H.i');
		}
	}

	/**
	 * action updateSeries
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @return void
	 */
	public function updateSeriesAction(\FKU\FkuAgenda\Domain\Model\Series $series) {
		// identify modified values
		$timezone = new \DateTimeZone('Europe/Zurich');
		$tempValues = $this->request->getArgument('series');
		$modifiedFields = [];
		$simpleFields = ['allDay','description','link','category','visible','newsText','weekdayWeekly','weekdayMonthly','weekdayOption','weekdayOption','interval','newsOption'];
		$eventFields = ['allDay','description','link','category','visible','newsText'];
		$copyFields = ['allDay','description','link','category','visible','newsText','rooms'];
		foreach ($tempValues as $field => $tempValue) {
			$original = $series->_getCleanProperty($field);
			if (in_array($field, $simpleFields)) {
				if (is_object($original)) {
					$old = strval($original->getUid());
				} else {
					$old = strval($original);
				}
			} else {
				switch ($field) {
					case '__identity':
						$old = 1;
						$tempValue = 1;
						break;
					case 'dateStart':
						$old = strval($original->format('d.m.Y'));
						$tempValue = strval($series->getDateStart()->format('d.m.Y'));
						break;
					case 'dateEnd':
						$old = strval($original->format('d.m.Y'));
						$tempValue = strval($series->getDateEnd()->format('d.m.Y'));
						break;
					case 'timeStart':
						if ($original) { $old = strval($original->format('H.i')); } else { $old = ''; }
						if ($series->getTimeStart()) { $tempValue = strval($series->getTimeStart()->format('H.i'));} else { $tempValue = ''; }
						break;
					case 'timeEnd':
						if ($original) { $old = strval($original->format('H.i')); } else { $old = ''; }
						if ($series->getTimeEnd()) { $tempValue = strval($series->getTimeEnd()->format('H.i'));} else { $tempValue = ''; }
						break;
					case 'rooms':
						$old = [];
						foreach ($original as $room) {
							$old[] = $room->getUid();
						}
						$tempValue = $series->getRoomArray();
						break;
				}
				
			}
			$dani .= '<br />'.$field.': ';
			if ($old != $tempValue) {
				$dani .= 'verändert';
				$modifiedFields[] = $field;
			}
		}

		$events = $this->eventRepository->findPerSeries($series);

		// upload and assign new file
		$storageRepository =  new \TYPO3\CMS\Core\Resource\StorageRepository;
		$storage = $storageRepository->findByUid(intval($this->settings['fileStorageUid']));
		$modifiedFiles = false;
		if (count($_FILES['tx_fkuagenda_month']['error'])) {
			foreach ($_FILES['tx_fkuagenda_month']['error'] as $fileId => $error) {
				if ($error == UPLOAD_ERR_OK) {
					
					// upload file
					$fileStoreName = $_FILES['tx_fkuagenda_month']['name'][$fileId];
					$fileTempName = $_FILES['tx_fkuagenda_month']['tmp_name'][$fileId];
					$fileObject = $storage->addFile($fileTempName, $storage->getRootLevelFolder(), $fileStoreName);
					$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
					$fileRef->setFile($fileObject);
					$series->addRelatedDocument($fileRef);
					foreach ($events as $event) {
						$fileRef = new \FKU\FkuAgenda\Domain\Model\FileReference;
						$fileRef->setFile($fileObject);
						$event->addRelatedDocument($fileRef);
					}
					$modifiedFiles = true;
				}
			}
		}
		
		// unlink (not delete) relation to files
		if ($this->request->hasArgument('delDocument')) {
			$delFiles = $this->request->getArgument('delDocument');
			if (sizeof($delFiles) > 0) {
				foreach ($delFiles as $fileId => $delete) {
					if ($delete) {
						// delete relation
						$fileRef = $this->fileReferenceRepository->findByUid($fileId);
						$fileUid = $fileRef->getOriginalFileIdentifier();
						$series->removeRelatedDocument($fileRef);
						$this->fileReferenceRepository->remove($fileRef);
						foreach ($events as $event) {
							$eventFileRef = $this->fileReferenceRepository->findByEventAndFile($event, $fileUid);
							if ($eventFileRef) {
								$this->fileReferenceRepository->remove($eventFileRef);
							}
						}
					}
				}
				$modifiedFiles = true;
			}
		}


		if (count($modifiedFields) == 0 and $modifiedFiles == false) {
			$this->addFlashMessage('Es wurden keine Anlässe verändert','',\TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
			$event = $events->getFirst();
			$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => $event->getEventStart()->format('n'),'year' => $event->getEventStart()->format('Y')));
		} else {
			$this->seriesRepository->update($series);
			$rooms = $series->getRooms();
	
			$modifiedDates = false;
			if (in_array('interval', $modifiedFields)) {
				$modifiedDates = true;
			} elseif (in_array('dateStart', $modifiedFields) or in_array('dateEnd', $modifiedFields)) {
				$modifiedDates = true;
			} else {
				if ($series->getInterval() == 1) {
					// monthly
					if (in_array('wwekdayOption', $modifiedFields) or in_array('weekdayMonhtly', $modifiedFields)) {
						$modifiedDates = true;
					}
				} else {
					// weekly
					if (in_array('weekdayWeekly', $modifiedFields)) {
						$modifiedDates = true;
					}
				}
			}
	
			$goto = [];
			$modified = ['updated' => [], 'deleted' => [], 'new' => []];
			$message = '';
	
			if ($modifiedDates and $series->getDateStart() and $series->getDateEnd()) {
				// Event dates have changed: overwrite existing events and delete or create events according to the needed number of events
				$start = strtotime($series->getDateStart()->format('j F Y'));
				$end = strtotime($series->getDateEnd()->format('j F Y'));
				$dates = $this->getSeriesDates($start, $end, $series->getInterval(), $series->getWeekdayWeekly(), $series->getWeekdayMonthly(), $series->getWeekdayOption());

				if (count($dates) == 0) {
					$this->addFlashMessage('Es gibt kein Anlassdatum im gewählten Datumsbereich. Die Änderungen wurden nicht gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
					$this->redirect('editSeries','Event','fkuagenda',array('series' => $series));
				}
				
				foreach ($events as $iterator => $event) {
					if ($iterator >= count($dates)) {
						// delete too many existing events
						$modified['deleted'][] = $event->getEventStart()->format('d.m.Y');
						$this->eventRepository->remove($event);
					} else {
						// update existing events
						$this->getEventDates($series, $event, $dates[$iterator]);
						$this->getNewsDates($series, $event);
						foreach ($eventFields as $field) {
							$newValue = $series->{'get'.ucfirst($field)}();
							$event->{'set'.ucfirst($field)}($newValue);
						}
						$event->setRooms(new ObjectStorage());
						foreach ($series->getRooms() as $room) {
							$event->addRoom($room);
						}
						$modified['updated'][] = $event->getEventStart()->format('d.m.Y');
						$this->eventRepository->update($event);
					}
					$this->persistenceManager->persistAll();
				}
				
				// create additional events
				for ($i=count($events); $i<count($dates); $i++) {
					$event = new \FKU\FkuAgenda\Domain\Model\Event;
					$this->getEventDates($series, $event, $dates[$i]);
					$this->getNewsDates($series, $event);
					$event->setSeries($series);
					
					foreach ($copyFields as $field) {
						if (\TYPO3\CMS\Extbase\Reflection\ObjectAccess::isPropertySettable($event, $field)) {
							$propertyValue = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getProperty($series, $field);
							if (is_object($propertyValue) && $propertyValue instanceof ObjectStorage) {
								$tmpStorage = new ObjectStorage;
								$tmpStorage->addAll($propertyValue);
								$propertyValue = $tmpStorage;
							}
							\TYPO3\CMS\Extbase\Reflection\ObjectAccess::setProperty($event, $field, $propertyValue);
						}
					}
					foreach ($series->getRelatedDocuments() as $fileRef) {
						$fileObject = clone GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($fileRef->getOriginalFileIdentifier());
						$newFileRef = new FileReference;
						$newFileRef->setFile($fileObject);
						$event->addRelatedDocument($newFileRef);
					}
					$modified['new'][] = $event->getEventStart()->format('d.m.Y');
					$this->eventRepository->add($event);
					$this->persistenceManager->persistAll();
				}
				$goto['month'] = date('n',$dates[0]);
				$goto['year'] = date('Y',$dates[0]);
			} else {
				// only update existing events
				foreach ($events as $event) {
					foreach ($modifiedFields as $field) {
						if (in_array($field, $eventFields)) {
							$newValue = $series->{'get'.ucfirst($field)}();
							$event->{'set'.ucfirst($field)}($newValue);
						} else {
							switch ($field) {
								case 'timeStart':
									$event->getEventStart()->setTime($series->getTimeStart()->format('H'),$series->getTimeStart()->format('i'));
									break;
								case 'timeEnd':
									$event->getEventEnd()->setTime($series->getTimeEnd()->format('H'),$series->getTimeEnd()->format('i'));
									break;
								case 'rooms':
									$event->setRooms(new ObjectStorage());
									foreach ($series->getRooms() as $room) {
										$event->addRoom($room);
									}
									break;
								case 'newsOption':
									$this->getNewsDates($series, $event);
									break;
							}
						}
					}
					$modified['updated'][] = $event->getEventStart()->format('d.m.Y');
					if (! $goto['month']) {
						$goto['month'] = $event->getEventStart()->format('n');
						$goto['year'] = $event->getEventStart()->format('Y');
					}
					$this->eventRepository->update($event);
					$this->persistenceManager->persistAll();
				}
			}
			if (count($modified['updated']) > 0) {
				$message .= 'Anlässe an folgenden Daten wurden aktualisiert: '.implode(' / ',$modified['updated']).'<br />';
			}
			if (count($modified['deleted']) > 0) {
				$message .= 'Anlässe an folgenden Daten wurden gelöscht: '.implode(' / ',$modified['deleted']).'<br />';
			}
			if (count($modified['new']) > 0) {
				$message .= 'Anlässe an folgenden Daten wurden erstellt: '.implode(' / ',$modified['new']).'<br />';
			}			
			$this->addFlashMessage($message,'',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
			$this->redirect('listMonthEdit','Event','fkuagenda',$goto);
		}
	}

	
	/**
	 * action copy
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("event")
	 * @return void
	 */
	public function copyAction(\FKU\FkuAgenda\Domain\Model\Event $event) {

		/*
		// Check if a flag is set because an event was just copied
		$copyFlag = intval($GLOBALS['TSFE']->fe_user->getKey('ses','agendaCopyFlag'));
		if ($copyFlag > 0) {
			$GLOBALS['TSFE']->fe_user->setKey('ses','agendaCopyFlag',0);
			$previouslyCopiedEvent = $this->eventRepository->findByUid($copyFlag);
			$this->redirect('edit','Event','fkuagenda',array('event' => $previouslyCopiedEvent));
		} else {
		*/
			$availableProperties = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getGettablePropertyNames($event);
			$newEvent = new \FKU\FkuAgenda\Domain\Model\Event;
			
			foreach ($availableProperties as $propertyName) {
				if (\TYPO3\CMS\Extbase\Reflection\ObjectAccess::isPropertySettable($newEvent, $propertyName) && !in_array($propertyName, array('uid','pid','series','relatedDocuments'))) {
					$propertyValue = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getProperty($event, $propertyName);
					if (is_object($propertyValue) && $propertyValue instanceof ObjectStorage) {
						$tmpStorage = new ObjectStorage;
						$tmpStorage->addAll($propertyValue);
						$propertyValue = $tmpStorage;
					}
					\TYPO3\CMS\Extbase\Reflection\ObjectAccess::setProperty($newEvent, $propertyName, $propertyValue);
				}
			}
			foreach ($event->getRelatedDocuments() as $fileRef) {
				$fileObject = clone GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($fileRef->getOriginalFileIdentifier());
				$newFileRef = new FileReference;
				$newFileRef->setFile($fileObject);
				$newEvent->addRelatedDocument($newFileRef);
			}
	
			$this->eventRepository->add($newEvent);
			$this->persistenceManager->persistAll();
	
			$this->addFlashMessage('Kopie des Anlasses wurde erstellt.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);

			// Setting a flag in cookies whne just created a copy
			/* $GLOBALS['TSFE']->fe_user->setKey('ses','agendaCopyFlag',$newEvent->getUid()); */
			$this->redirect('edit','Event','fkuagenda',array('event' => $newEvent));
		/* } */

	}


	/**
	 * action delete
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return void
	 */
	public function deleteAction(\FKU\FkuAgenda\Domain\Model\Event $event) {
		$this->eventRepository->remove($event);
		$this->addFlashMessage('Der Anlass wurde gelöscht.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => $event->getEventStart()->format('n'),'year' => $event->getEventStart()->format('Y')));
	}


	/**
	 * action deleteSeries
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @return void
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("event")
	 */
	public function deleteSeriesAction(\FKU\FkuAgenda\Domain\Model\Series $series) {
		$events = $this->eventRepository->findPerSeries($series);
		foreach ($events as $event) {
			$this->eventRepository->remove($event);
			$this->persistenceManager->persistAll();
		}
		$this->seriesRepository->remove($series);
		$this->addFlashMessage('Die Serie mit allen zugehörigen Anlässen wurde gelöscht.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
		$this->redirect('listMonthEdit','Event','fkuagenda',array('month' => $series->getDateStart()->format('n'),'year' => $series->getDateStart()->format('Y')));
	}


	/**
	 * action ics
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return void
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("event")
	 */
	public function icsAction(\FKU\FkuAgenda\Domain\Model\Event $event = NULL) {
		
		// After splitting the plugin View into several others, many requests for plugin tx_fkuagenda_view with action=ics reached the website without a referrer.
		// To reduce the error messages in the log, $event can be NULL and is checked only inside the function to be true.
		if ($event) {

			$title = $this->settings['ics']['prefix'].$this->replaceUmlaute($event->getDescriptionFirstLine()).'_'.$event->getEventStart()->format('Y-m-d').'.ics';
			header ('Expires: 0');
			header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header ('Content-Disposition: attachment; filename=' . $title);
			header ('Content-Type: text/ics');
			
			$hasCategory = true;
			if (! $event->getCategory()) {
				$hasCategory = false; // could be due to missing or hidden cagegory
			}
			if ($event->getAllDay()) {
				$prefix = 'VALUE=DATE';
				$begin = $event->getEventStart()->format('Ymd');
				if ($event->getEventEnd() and $event->getEventStart() != $event->getEventEnd()) {
					$end = date('Ymd', strtotime('+1 days',$event->getEventEnd()->getTimestamp()));
				} else {
					$end = $begin;
				}
			} else {
				$prefix = 'TZID=Europe/Berlin';
				$begin = $event->getEventStart()->format('Ymd\THis');
				if ($event->getEventEnd() and $event->getEventStart() != $event->getEventEnd()) {
					$end = $event->getEventEnd()->format('Ymd\THis');
				} elseif ($hasCategory && $event->getCategory()->getDuration() > 0) {
					$duration = $event->getCategory()->getDuration();
					$time = strtotime('+'.$duration.' minutes',$event->getEventStart()->format('U'));
					$end = date('Ymd\THis',$time);
				} else {
					$end = $begin;
				}
			}
	
			$this->view->assignMultiple(array(
				'event' => $event,
				'begin' => $begin,
				'end' => $end,
				'prefix' => $prefix,
			));

		}			
	}

	/**
	 * Create correct dateTime objects when saving event
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return \FKU\FkuAgenda\Domain\Model\Event
	 */
	protected function getDateTimeEntries (\FKU\FkuAgenda\Domain\Model\Event $event) {
		$yearPrefix = floor($event->getEventStartDate()->format('Y')/100);
		if ($yearPrefix < 19) {
			$yearPrefix = 20;
		}
		
		if ($event->getAllDay() == 1) {
			$dateStringStart = $yearPrefix . $event->getEventStartDate()->format('y-m-d').' 00:00:00';
			if ($event->getEventEndDate()) {
				$dateStringEnd = $yearPrefix . $event->getEventEndDate()->format('y-m-d').' 00:00:00';
			} else {
				$dateStringEnd = $dateStringStart;
			}
		} elseif ($event->getAllDay() == 2) {
			$dateStringStart = $yearPrefix . $event->getEventStartDate()->format('y-m-d').' 23:59:59';
			if ($event->getEventEndDate()) {
				$dateStringEnd = $yearPrefix . $event->getEventEndDate()->format('y-m-d').' 23:59:59';
			} else {
				$dateStringEnd = $dateStringStart;
			}
		} else {
			if ($event->getEventStartTime()) {
				$dateStringStart = $yearPrefix . $event->getEventStartDate()->format('y-m-d').' '.$event->getEventStartTime()->format('H:i').':00';
			} else {
				$dateStringStart = $yearPrefix . $event->getEventStartDate()->format('y-m-d').' 00:00:00';
				$event->setAllDay(1);
			}
			if ($event->getEventEndDate()) {
				if ($event->getEventEndTime()) {
					$dateStringEnd = $yearPrefix . $event->getEventEndDate()->format('y-m-d').' '.$event->getEventEndTime()->format('H:i').':00';
				} else {
					$dateStringEnd = $yearPrefix . $event->getEventEndDate()->format('y-m-d').' 00:00:00';
				}
			} else {
				if ($event->getEventEndTime()) {
					$dateStringEnd = $yearPrefix . $event->getEventStartDate()->format('y-m-d').' '.$event->getEventEndTime()->format('H:i').':00';
				} else {
					$dateStringEnd = $dateStringStart;
				}
			}
		}
		$event->setEventStart(new \DateTime($dateStringStart));
		$event->setEventEnd(new \DateTime($dateStringEnd));
		
		if ($event->getNewsStartDate()) {
			if ($event->getNewsStartTime()) {
				$dateStringStartNews = $yearPrefix . $event->getNewsStartDate()->format('y-m-d').' '.$event->getNewsStartTime()->format('H:i').':00';

			} else {
				$dateStringStartNews = $yearPrefix . $event->getNewsStartDate()->format('y-m-d').' 00:00:00';
			}
			if ($event->getNewsEndDate()) {
				if ($event->getNewsEndTime()) {
					$dateStringEndNews = $yearPrefix . $event->getNewsEndDate()->format('y-m-d').' '.$event->getNewsEndTime()->format('H:i').':00';
				} else {
					$dateStringEndNews = $yearPrefix . $event->getNewsEndDate()->format('y-m-d').' 23:59:59';
				}
			} else {
				if ($event->getNewsEndTime()) {
					$dateStringEndNews = $yearPrefix . $event->getNewsStartDate()->format('y-m-d').' '.$event->getNewsEndTime()->format('H:i').':00';
				} else {
					$dateStringEndNews = $dateStringEnd;
				}
			}
			$event->setNewsStart(new \DateTime($dateStringStartNews));
			$event->setNewsEnd(new \DateTime($dateStringEndNews));
		} else{
			$event->setNewsStart(NULL);
			$event->setNewsEnd(NULL);
		}

		return $event;
	}

	/**
	 * geteSeriesDates
	 *
	 * @param \timstamp $start
	 * @param \timstamp $end
	 * @param \integer $interval 0=weekly, 1=monthly
	 * @param \integer $weekdayWeekly
	 * @param \integer $weekdayMonthly
	 * @param \integer $weekdayOption
	 * @return \array $dates
	 */
	protected function getSeriesDates ($start, $end, $interval, $weekdayWeekly=1, $weekdayMonthly=1, $weekdayOption=1) {
		$dates = [];
		if ($start <= $end) {
			if ($interval == 0) {
				// weekly dates
				$wday = $weekdayWeekly;
				if ($wday > 6) { $wday = $wday-7; }
				$dates[0] = $start;
				while (date('w',$dates[0]) != $wday) {
					$dates[0] = strtotime('+1 days', $dates[0]);
				}
				if ($dates[0] <= $end) {
					$lastDate = $dates[0];
					$newDate = strtotime('+1 weeks', $lastDate);
					while ($newDate <= $end) {
						$dates[] = $newDate;
						$lastDate = $newDate;
						$newDate = strtotime('+1 weeks', $lastDate);
						if (count($dates) > 100) { die('Zu viele Daten: '.$start.' '.$end.' '.$wday.' '.$dates[0].' '.$dates[1].' '.$dates[2]); }
					}
				} else {
					$dates = [];
				}
			} else {
				// monthly dates
				$wday = $weekdayMonthly;
				if ($wday > 6) { $wday = $wday-7; }
				$weekNo = $weekdayOption-1;
				if ($weekNo < 0 or $weekNo > 4) { $weekNo = 0; }
				if ($weekNo != 4) {
					// first, second, third or fourth week per month, but not last week per month
					$newDate = $start;
					$minDay = $weekNo * 7 + 1;
					$maxDay = ($weekNo+1) * 7;
					while (date('w',$newDate) != $wday or date('j',$newDate) < $minDay or date('j',$newDate) > $maxDay) {
						$newDate = strtotime('+1 days', $newDate);
					}
					while ($newDate <= $end) {
						$dates[] = $newDate;
						$newDate = strtotime('+4 weeks', $newDate);
						if (date('j',$newDate) < $minDay or date('j',$newDate) > $maxDay) {
							$newDate = strtotime('+1 weeks', $newDate);
						}
						if (count($dates) > 100) { die('Zu viele Daten: '.$start.' '.$end.' '.$wday.' '.$dates[0].' '.$dates[1].' '.$dates[2]); }
					}
				} else {
					// last week per month
					$newDate = $start;
					$minDay = date('t',$newDate)-6;
					while (date('w',$newDate) != $wday or date('j',$newDate) < $minDay) {
						$newDate = strtotime('+1 days',$newDate);
						$minDay = date('t',$newDate)-6;
					}
					while ($newDate <= $end) {
						$dates[] = $newDate;
						$newDate = strtotime ('+4 weeks', $newDate);
						$minDay = date('t',$newDate)-6;
						if (date('j',$newDate) < $minDay) {
							$newDate = strtotime ('+1 weeks', $newDate);
						}
						if (count($dates) > 100) { die('Zu viele Daten: '.$start.' '.$end.' '.$wday.' '.$dates[0].' '.$dates[1].' '.$dates[2]); }
					}
				}
			}
		}
		return $dates;
	}


	/**
	 * Get event's start date based on series
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @param \DateTime $eventDate
	 * @return void
	 */
	protected function getEventDates (\FKU\FkuAgenda\Domain\Model\Series $series, \FKU\FkuAgenda\Domain\Model\Event &$event, $eventDate) {
		if ($series->getTimeStart()) {
			$dateStringStart = date('Y-m-d',$eventDate).' '.$series->getTimeStart()->format('H:i').':00';
			if ($series->getTimeEnd()) {
				$dateStringEnd = date('Y-m-d',$eventDate).' '.$series->getTimeEnd()->format('H:i').':00';
			} else {
				$dateStringEnd = date('Y-m-d',$eventDate).' '.$series->getTimeStart()->format('H:i').':00';
			}
		} else {
			if ($series->getAllDay() == 2) {
				$dateStringStart = date('Y-m-d',$eventDate).' 23:59:59';
				$dateStringEnd = date('Y-m-d',$eventDate).' 23:59:59';
			} else {
				$dateStringStart = date('Y-m-d',$eventDate).' 00:00:00';
				$dateStringEnd = date('Y-m-d',$eventDate).' 00:00:00';
			}
		}
		$event->setEventStart(new \DateTime($dateStringStart));
		$event->setEventEnd(new \DateTime($dateStringEnd));
	}


	/**
	 * Get event's news dates based on series
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @param \FKU\FkuAgenda\Domain\Model\Event $event
	 * @return boolean
	 */
	protected function getNewsDates (\FKU\FkuAgenda\Domain\Model\Series $series, \FKU\FkuAgenda\Domain\Model\Event &$event) {
		if ($series->getNewsOption() == 0) {
			$event->setNewsStart(NULL);
			$event->setNewsEnd(NULL);
			return false;
		} else {
			$eventDate = $event->getEventStart()->format('U');
			$eventEnd = $event->getEventEnd();
			switch ((integer)$series->getNewsOption()) {
				case 1:
					$newsDate = strtotime('-1 days',$eventDate);
					break;
				case 2:
					$newsDate = strtotime('-2 days',$eventDate);
					break;
				case 3:
					$newsDate = strtotime('-3 days',$eventDate);
					break;
				case 4:
					$newsDate = strtotime('-4 days',$eventDate);
					break;
				case 5:
					$newsDate = strtotime('-5 days',$eventDate);
					break;
				case 6:
					$newsDate = strtotime('-1 weeks',$eventDate);
					break;
				case 7:
					$newsDate = strtotime('-2 weeks',$eventDate);
					break;
				case 8:
					$newsDate = strtotime('-1 months',$eventDate);
					break;
			}
			$dateStringNews = date('Y-m-d',$newsDate).' 00:00:00';
			$event->setNewsStart(new \DateTime($dateStringNews));
			$event->setNewsEnd(clone $eventEnd);
			return true;
		}
	}
	
	
	/**
	 * Get year and month from selection
	 *
	 * @return array
	 */
	protected function getYearAndMonth () {
		
		// get month and year from cookies
		$year = intval($GLOBALS['TSFE']->fe_user->getKey('ses','agendaListYear'));
		$month = intval($GLOBALS['TSFE']->fe_user->getKey('ses','agendaListMonth'));
		
		// overwrite month and year from selected values
		if ($this->request->hasArgument('year')) { $year = $this->request->getArgument('year'); }
		if ($this->request->hasArgument('month')) { $month = $this->request->getArgument('month'); }

		// overwrite month and year with actual values if they are not useful
		$currentYear = date('Y');
		if ($year === NULL or $year < 2014 or $year > $currentYear+2) {
			$year = $currentYear;
			$month = date('n');
		}
		if ($month === NULL or $month < 1 or $month > 12) {
			$month = date('n');
		}

		// save month and year in cookies
		$GLOBALS['TSFE']->fe_user->setKey('ses','agendaListMonth',$month);
		$GLOBALS['TSFE']->fe_user->setKey('ses','agendaListYear',$year);
		
		return ['year' => $year, 'month' => $month];
	}
	
	/**
	 * Create pagination array
	 *
	 * @param integer $thisMonth recent month (1-12)
	 * @param integer $thisYear recent year (e.g. 2014)
	 * @param integer $noPrevMonths number of additional months to the left (beside arrows)
	 * @param integer $noNextMonths number of additional months to the right (beside arrows)
	 * @param string $layout Layout code of the page
	 * @param integer $category uid of agenda category for limitation of displayed events
	 * @return array
	 */
	protected function getPagination ($thisMonth, $thisYear, $noPrevMonths=0, $noNextMonths=0, $layout='Default', $category=NULL) {

		$left = $noPrevMonths+1;
		$right = $noNextMonths+1;
		
		$pagination = array ('classic', 'month', 'year');
		
		// classic style
		$page = array();
		for ($i=$left;$i>=1;$i--) {
			$nextMonth = $thisMonth-$i;
			$nextYear = $thisYear;
			if ($nextMonth < 1) {
				$nextMonth = $nextMonth+12;
				$nextYear = $thisYear-1;
			}
			$label = $this->monatsnamen[$nextMonth];
			if ($i==$left) { $label = '«'; }
			$page[] = array ('class' => '', 'label' => $label, 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		}
		$page[] = array ('class' => 'active', 'label' => $this->monatsnamen[$thisMonth], 'arguments' => array ('month' => $thisMonth, 'year' => $thisYear, 'category' => $category, 'layout' => $layout));
		for ($i=1;$i<=$right;$i++) {
			$nextMonth = $thisMonth+$i;
			$nextYear = $thisYear;
			if ($nextMonth > 12) {
				$nextMonth = $nextMonth-12;
				$nextYear = $thisYear+1;
			}
			$label = $this->monatsnamen[$nextMonth];
			if ($i==$right) { $label = '»'; }
			$page[] = array ('class' => '', 'label' => $label, 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		}
		$pagination['classic'] = $page;
		
		// month and year style
		$page = array ();
		$nextMonth = $thisMonth-1;
		$nextYear = $thisYear;
		if ($nextMonth < 1) {
			$nextMonth = 12;
			$nextYear--;
		}
		if ($nextYear < 2014) {
			$page[] = array ('class' => 'disabled', 'label' => '«', 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		} else {
			$page[] = array ('class' => '', 'label' => '«', 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		}
		for ($i=1;$i<=12;$i++) {
			if ($i == $thisMonth) {
				$class = 'active';
			} else {
				$class = '';
			}
			$page[] = array ('class' => $class, 'label' => $this->monatsnamenKurz[$i], 'arguments' => array ('month' => $i, 'year' => $thisYear, 'category' => $category, 'layout' => $layout));
		}
		$nextMonth = $thisMonth+1;
		$nextYear = $thisYear;
		if ($nextMonth > 12) {
			$nextMonth = 1;
			$nextYear++;
		}
		if ($nextYear > date('Y')+2) {
			$page[] = array ('class' => 'disabled', 'label' => '»', 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		} else {
			$page[] = array ('class' => '', 'label' => '»', 'arguments' => array ('month' => $nextMonth, 'year' => $nextYear, 'category' => $category, 'layout' => $layout));
		}
		$pagination['month'] = $page;
		
		$page = array();
		if ($thisYear <= 2014) {
			$page[] = array ('class' => 'disabled', 'label' => '«', 'arguments' => array ('month' => 12, 'year' => $thisYear-1, 'category' => $category, 'layout' => $layout));
		} else {
			$page[] = array ('class' => '', 'label' => '«', 'arguments' => array ('month' => 12, 'year' => $thisYear-1, 'category' => $category, 'layout' => $layout));
		}
		$page[] = array ('class' => 'active', 'label' => $thisYear, 'arguments' => array ('month' => $thisMonth, 'year' => $thisYear, 'category' => $category, 'layout' => $layout));
		if ($thisYear >= date('Y')+2) {
			$page[] = array ('class' => 'disabled', 'label' => '»', 'arguments' => array ('month' => 1, 'year' => $thisYear+1, 'category' => $category, 'layout' => $layout));
		} else {
			$page[] = array ('class' => '', 'label' => '»', 'arguments' => array ('month' => 1, 'year' => $thisYear+1, 'category' => $category, 'layout' => $layout));
		}
		$pagination['year'] = $page;
		
		return $pagination;
	}

	/**
	 * Replace German Umlaute
	 *
	 * @param string $text
	 * @return string
	 */
	protected function replaceUmlaute($text = '') {
		$search  = array ('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', ' ');
		$replace = array ('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', '_');
		$new_text  = str_replace($search, $replace, $text);
		return $new_text;
	}

	/**
	 * Remove line with name of preacher from event descriptions
	 *
	 * @param TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $events
	 * @return $events
	 */
	protected function removePreacher($events) {
		foreach ($events as $key => $event) {
			$description = $event->getDescription();
			if (preg_match('/Predigt.*\n/', $description, $result)) {
				$events[$key]->setDescription(str_replace($result[0],'',$description));
			}
		}
		return $events;
	}
}
?>