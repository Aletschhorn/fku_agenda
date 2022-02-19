<?php
namespace FKU\FkuAgenda\Domain\Model;

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
/**
 *
 *
 * @package fku_agenda
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * hidden
	 *
	 * @var boolean
	 */
	protected $hidden;
  	
	/**
	 * description
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $description;

	/**
	 * descriptionFirstLine
	 *
	 * @var \string
	 */
	protected $descriptionFirstLine;

	/**
	 * descriptionRest
	 *
	 * @var \string
	 */
	protected $descriptionRest;

	/**
	 * eventStart
	 *
	 * @var \DateTime
	 */
	protected $eventStart;

	/**
	 * eventStartDate
	 *
	 * @var \DateTime
	 */
	protected $eventStartDate;

	/**
	 * eventStartTime
	 *
	 * @var \DateTime
	 */
	protected $eventStartTime;

	/**
	 * eventStartTimeFormat
	 *
	 * @var \string
	 */
	protected $eventStartTimeFormat;

	/**
	 * eventEnd
	 *
	 * @var \DateTime
	 */
	protected $eventEnd;

	/**
	 * eventEndDate
	 *
	 * @var \DateTime
	 */
	protected $eventEndDate;

	/**
	 * eventEndTime
	 *
	 * @var \DateTime
	 */
	protected $eventEndTime;

	/**
	 * allDay
	 *
	 * @var integer
	 */
	protected $allDay;

	/**
	 * severalDays
	 *
	 * @var boolean
	 */
	protected $severalDays;

	/**
	 * link
	 *
	 * @var \string
	 */
	protected $link;

	/**
	 * relatedDocuments
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\FileReference>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
	 */
	protected $relatedDocuments;

	/**
	 * newsStart
	 *
	 * @var \DateTime
	 */
	protected $newsStart;

	/**
	 * newsStartDate
	 *
	 * @var \DateTime
	 */
	protected $newsStartDate;

	/**
	 * newsStartTime
	 *
	 * @var \DateTime
	 */
	protected $newsStartTime;

	/**
	 * newsEnd
	 *
	 * @var \DateTime
	 */
	protected $newsEnd;

	/**
	 * newsEndDate
	 *
	 * @var \DateTime
	 */
	protected $newsEndDate;

	/**
	 * newsEndTime
	 *
	 * @var \DateTime
	 */
	protected $newsEndTime;

	/**
	 * newsText
	 *
	 * @var \string
	 */
	protected $newsText;

	/**
	 * crdate
	 *
	 * @var \DateTime
	 */
	protected $crdate;

	/**
	 * tstamp
	 *
	 * @var \DateTime
	 */
	protected $tstamp;

	/**
	 * rooms
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Room>
	 */
	protected $rooms;

	/**
	 * roomArray
	 *
	 * @var array
	 */
	protected $roomArray;

	/**
	 * resources
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Resource>
	 */
	protected $resources;

	/**
	 * category
	 *
	 * @var \FKU\FkuAgenda\Domain\Model\Category
	 */
	protected $category;

	/**
	 * visible
	 *
	 * @var \FKU\FkuAgenda\Domain\Model\VisibilityCategory
	 */
	protected $visible;

	/**
	 * series
	 *
	 * @var \FKU\FkuAgenda\Domain\Model\Series
	 */
	protected $series;

	/**
	 * __construct
	 *
	 * @return Event
	 */
	public function __construct() {

		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->rooms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->resources = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->relatedDocuments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Returns the descriptionFirstLine
	 *
	 * @return \string $descriptionFirstLine
	 */
	public function getDescriptionFirstLine() {
		$stop = strpos($this->description,chr(13));
		if ($stop > 0) {
			return substr($this->description,0,$stop);
		} else {
			return $this->description;
		}
	}

	/**
	 * Returns the descriptionRest
	 *
	 * @return \string $descriptionRest
	 */
	public function getDescriptionRest() {
		$start = strpos($this->description,chr(13));
		if ($start > 0) {
			return trim(substr($this->description,$start));
		} else {
			return NULL;
		}
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = trim($description);
	}

	/**
	 * Returns the description for textarea field
	 *
	 * @return \string $descriptionTextarea
	 */
	public function getDescriptionTextarea() {
		return str_replace(chr(13),'',str_replace(chr(10),chr(11),$this->description));
	}

	/**
	 * Returns the eventStart
	 *
	 * @return \DateTime $eventStart
	 */
	public function getEventStart() {
		return $this->eventStart;
	}

	/**
	 * Returns the eventStartDate
	 *
	 * @return \DateTime $eventStartDate
	 */
	public function getEventStartDate() {
		return $this->eventStartDate;
	}

	/**
	 * Sets the eventStartDate
	 *
	 * @param \DateTime $eventStartDate
	 * @return void
	 */
	public function setEventStartDate($eventStartDate) {
		$this->eventStartDate = $eventStartDate;
	}

	/**
	 * Returns the eventStartDay
	 *
	 * @return integer $eventStartDay
	 */
	public function getEventStartDay() {
		return $this->eventStart->format('j');
	}

	/**
	 * Returns the eventStartTime
	 *
	 * @return \DateTime $eventStartTime
	 */
	public function getEventStartTime() {
		return $this->eventStartTime;
	}

	/**
	 * Sets the eventStartTime
	 *
	 * @param \DateTime $eventStartTime
	 * @return void
	 */
	public function setEventStartTime($eventStartTime) {
		$this->eventStartTime = $eventStartTime;
	}

	/**
	 * Returns the eventStartTimeFormat
	 *
	 * @return string $eventStartTimeFormat
	 */
	public function getEventStartTimeFormat() {
		if ($this->eventStartTime) {
			$time = $this->eventStartTime->format('H:i');
			if ($time == '00:00') { $time = ''; }
			return $time;
		} else {
			return '';
		}
	}

	/**
	 * Returns the eventStartMonth
	 *
	 * @return string $eventStartMonth
	 */
	public function getEventStartMonth() {
		$monatsnamen = array('','Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember');
		$month = $this->eventStart->format('n');
		return $monatsnamen[$month];
	}

	/**
	 * Returns the eventEndDate
	 *
	 * @return \DateTime $eventEndDate
	 */
	public function getEventEndDate() {
		return $this->eventEndDate;
	}

	/**
	 * Sets the eventEndDate
	 *
	 * @param \DateTime $eventEndDate
	 * @return void
	 */
	public function setEventEndDate($eventEndDate) {
		$this->eventEndDate = $eventEndDate;
	}

	/**
	 * Returns the eventEndTime
	 *
	 * @return \DateTime $eventEndTime
	 */
	public function getEventEndTime() {
		return $this->eventEndTime;
	}

	/**
	 * Sets the eventEndTime
	 *
	 * @param \DateTime $eventEndTime
	 * @return void
	 */
	public function setEventEndTime($eventEndTime) {
		$this->eventEndTime = $eventEndTime;
	}

	/**
	 * Returns the eventEndTimeFormat
	 *
	 * @return \int $eventEndTimeFormat
	 */
	public function getEventEndTimeFormat() {
		$time = '';
		if ($this->eventEnd > 0 and $this->eventStart != $this->eventEnd) {
			$time = $this->eventEnd->format('H:i');
			if ($time == '00:00') { $time = ''; }
		}
		return $time;
	}

	/**
	 * Returns the eventStartWeekdayCode
	 *
	 * @return \int $eventStartWeekdayCode
	 */
	public function getEventStartWeekdayCode() {
		return $this->eventStart->format('w');
	}

	/**
	 * Sets the eventStart
	 *
	 * @param \DateTime $eventStart
	 * @return void
	 */
	public function setEventStart($eventStart) {
		$this->eventStart = $eventStart;
	}

	/**
	 * Returns the eventEnd
	 *
	 * @return \DateTime $eventEnd
	 */
	public function getEventEnd() {
		if ($this->eventEnd) {
			return $this->eventEnd;
		} else {
			return $this->eventStart;
		}
	}

	/**
	 * Sets the eventEnd
	 *
	 * @param \DateTime $eventEnd
	 * @return void
	 */
	public function setEventEnd($eventEnd) {
		$this->eventEnd = $eventEnd;
	}

	/**
	 * Returns the allDay
	 *
	 * @return integer $allDay
	 */
	public function getAllDay() {
		return $this->allDay;
	}
	
	/**
	 * Sets the allDay
	 *
	 * @param integer $allDay
	 * @return void
	 */
	public function setAllDay($allDay) {
		$this->allDay = $allDay;
	}

	/**
	 * Returns the severalDays
	 *
	 * @return boolean $severalDays
	 */
	public function getSeveralDays() {
		if (! $this->eventEnd) {
			$this->eventEnd = $this->eventStart;
		}
		if ($this->eventEnd->format('Ymd') > $this->eventStart->format('Ymd')) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns the today flag
	 *
	 * @return boolean $today
	 */
	public function getToday() {
		if (date('Ymd') == $this->eventStart->format('Ymd')) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the tomorrow flag
	 *
	 * @return boolean $tomorrow
	 */
	public function getTomorrow() {
		if (date('Ymd',time()+86400) == $this->eventStart->format('Ymd')) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the link
	 *
	 * @return \string $link
	 */
	public function getLink() {
		return $this->link;
	}
	
	/**
	 * Sets the link
	 *
	 * @param \string $link
	 * @return void
	 */
	public function setLink($link) {
		$this->link = $link;
	}
	
	/**
	 * Returns the relatedDocuments
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\FileReference> $relatedDocuments
	 */
	public function getRelatedDocuments() {
		return $this->relatedDocuments;
	}

	/**
	 * Sets the relatedDocuments
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\FileReference> $relatedDocuments
	 * @return void
	 */
	public function setRelatedDocuments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedDocuments) {
		$this->relatedDocuments = $relatedDocuments;
	}

	/**
	 * Adds a relatedDocument
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\FileReference $relatedDocument
	 * @return void
	 */
	public function addRelatedDocument(\FKU\FkuAgenda\Domain\Model\FileReference $relatedDocument) {
		$this->relatedDocuments->attach($relatedDocument);
	}

	/**
	 * Removes a relatedDocument
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\FileReference $relatedDocument
	 * @return void
	 */
	public function removeRelatedDocument(\FKU\FkuAgenda\Domain\Model\FileReference $relatedDocument) {
		$this->relatedDocuments->detach($relatedDocument);
	}

	/**
	 * Returns the newsStart
	 *
	 * @return \DateTime $newsStart
	 */
	public function getNewsStart() {
		return $this->newsStart;
	}

	/**
	 * Sets the newsStart
	 *
	 * @param \DateTime $newsStart
	 * @return void
	 */
	public function setNewsStart($newsStart) {
		$this->newsStart = $newsStart;
	}

	/**
	 * Returns the newsStartDate
	 *
	 * @return \DateTime $newsStartDate
	 */
	public function getNewsStartDate() {
		return $this->newsStartDate;
	}

	/**
	 * Returns the newsStartDate
	 *
	 * @param \DateTime $newsStartDate
	 * @return void
	 */
	public function setNewsStartDate($newsStartDate) {
		$this->newsStartDate = $newsStartDate;
	}

	/**
	 * Returns the newsStartTime
	 *
	 * @return \DateTime $newsStartTime
	 */
	public function getNewsStartTime() {
		return $this->newsStartTime;
	}

	/**
	 * Sets the newsStartTime
	 *
	 * @param \DateTime $newsStartTime
	 * @return void
	 */
	public function setNewsStartTime($newsStartTime) {
		$this->newsStartTime = $newsStartTime;
	}

	/**
	 * Returns the newsEnd
	 *
	 * @return \DateTime $newsEnd
	 */
	public function getNewsEnd() {
		return $this->newsEnd;
	}

	/**
	 * Sets the newsEnd
	 *
	 * @param \DateTime $newsEnd
	 * @return void
	 */
	public function setNewsEnd($newsEnd) {
		$this->newsEnd = $newsEnd;
	}

	/**
	 * Returns the newsEndDate
	 *
	 * @return \DateTime $newsEndDate
	 */
	public function getNewsEndDate() {
		return $this->newsEndDate;
	}

	/**
	 * Sets the newsEndDate
	 *
	 * @param \DateTime $newsEndDate
	 * @return void
	 */
	public function setNewsEndDate($newsEndDate) {
		$this->newsEndDate = $newsEndDate;
	}

	/**
	 * Returns the newsEndTime
	 *
	 * @return \DateTime $newsEndTime
	 */
	public function getNewsEndTime() {
		return $this->newsEndTime;
	}

	/**
	 * Sets the newsEndTime
	 *
	 * @param \DateTime $newsEnTime
	 * @return void
	 */
	public function setNewsEndTime($newsEndTime) {
		$this->newsEndTime = $newsEndTime;
	}

	/**
	 * Returns the newsText
	 *
	 * @return \string $newsText
	 */
	public function getNewsText() {
		return $this->newsText;
	}

	/**
	 * Sets the newsText
	 *
	 * @param \string $newsText
	 * @return void
	 */
	public function setNewsText($newsText) {
		$this->newsText = $newsText;
	}

	/**
	 * Adds a Room
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Room $room
	 * @return void
	 */
	public function addRoom(\FKU\FkuAgenda\Domain\Model\Room $room) {
		$this->rooms->attach($room);
	}

	/**
	 * Removes a Room
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Room $roomToRemove The Room to be removed
	 * @return void
	 */
	public function removeRoom(\FKU\FkuAgenda\Domain\Model\Room $roomToRemove) {
		$this->rooms->detach($roomToRemove);
	}
	/**
	 * Returns the rooms
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Room> $rooms
	 */
	public function getRooms() {
		return $this->rooms;
	}
	/**
	 * Returns the room uids in an array
	 *
	 * @return \array $roomArray
	 */
	public function getRoomArray() {
		$roomArray = array ();
		foreach ($this->rooms as $room) {
			$roomArray[] = $room->getUid();
		}
		return $roomArray;
//		return $this->rooms->toArray();
	}
	/**
	 * Sets the rooms
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Room> $rooms
	 * @return void
	 */
	public function setRooms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rooms) {
		$this->rooms = $rooms;
	}
	/**
	 * Adds a Resource
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Resource $resource
	 * @return void
	 */
	public function addResource(\FKU\FkuAgenda\Domain\Model\Resource $resource) {
		$this->resources->attach($resource);
	}
	/**
	 * Removes a Resource
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Resource $resourceToRemove The Resource to be removed
	 * @return void
	 */
	public function removeResource(\FKU\FkuAgenda\Domain\Model\Resource $resourceToRemove) {
		$this->resources->detach($resourceToRemove);
	}
	/**
	 * Returns the resources
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Resource> $resources
	 */
	public function getResources() {
		return $this->resources;
	}
	/**
	 * Returns the resource uids in an array
	 *
	 * @return \array $resourceArray
	 */
	public function getResourceArray() {
		$resourceArray = array ();
		foreach ($this->resources as $resource) {
			$resourceArray[] = $resource->getUid();
		}
		return $resourceArray;
	}
	/**
	 * Sets the resources
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FKU\FkuAgenda\Domain\Model\Resource> $resources
	 * @return void
	 */
	public function setResources(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resources) {
		$this->resources = $resources;
	}

	/**
	 * Returns the category
	 *
	 * @return \FKU\FkuAgenda\Domain\Model\Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Category $category
	 * @return void
	 */
	public function setCategory(\FKU\FkuAgenda\Domain\Model\Category $category) {
		$this->category = $category;
	}
	
	/**
	 * Returns the visible
	 *
	 * @return \FKU\FkuAgenda\Domain\Model\VisibilityCategory $visible
	 */
	public function getVisible() {
		if ($this->visible) {
			return $this->visible;
		} else {
			return array ('uid' => 1);
		}
	}

	/**
	
	 * Sets the visible
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\VisibilityCategory $visible
	 * @return void
	 */
	public function setVisible(\FKU\FkuAgenda\Domain\Model\VisibilityCategory $visible) {
		$this->visible = $visible;
	}
	
	/**
	 * Returns the series
	 *
	 * @return \FKU\FkuAgenda\Domain\Model\Series $series
	 */
	public function getSeries() {
		return $this->series;
	}

	/**
	 * Sets the series
	 *
	 * @param \FKU\FkuAgenda\Domain\Model\Series $series
	 * @return void
	 */
	public function setSeries(\FKU\FkuAgenda\Domain\Model\Series $series) {
		$this->series = $series;
	}

	/**
	 * Removes the series
	 *
	 * @return void
	 */
	public function removeSeries() {
		$this->series = 0;
	}

	/**
	 * Returns the number of events at today's date
	 *
	 * @return \int 
	 */
	public function getCounter() {
		return $this->counter;
	}

	/**
	 * Returns the crdate
	 *
	 * @return \DateTime $crdate
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 * Returns the tstamp
	 *
	 * @return \DateTime $tstamp
	 */
	public function getTstamp() {
		return $this->tstamp;
	}
	
	/**
	 * @return boolean $hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}
	
	/**
	 * @return boolean $hidden
	 */
	public function isHidden() {
		return $this->getHidden();
	}
	
	/**
	 * @param boolean $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}
	
	/**
	 * Reset UID in order to clone an object
	 *
	 * @return void
	 */
	public function resetUid() {
		$this->setUid(NULL);
		$this->_setClone(FALSE);
		$this->_isNew(TRUE);
	}
}
?>