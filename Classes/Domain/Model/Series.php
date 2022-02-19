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
class Series extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * description
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $description;

	/**
	 * dateStart
	 *
	 * @var \DateTime
	 */
	protected $dateStart;

	/**
	 * dateEnd
	 *
	 * @var \DateTime
	 */
	protected $dateEnd;

	/**
	 * timeStart
	 *
	 * @var \DateTime
	 */
	protected $timeStart;

	/**
	 * timeEnd
	 *
	 * @var \DateTime
	 */
	protected $timeEnd;

	/**
	 * interval
	 *
	 * @var integer
	 */
	protected $interval;

	/**
	 * weekdayWeekly
	 *
	 * @var integer
	 */
	protected $weekdayWeekly;

	/**
	 * weekdayMonthly
	 *
	 * @var integer
	 */
	protected $weekdayMonthly;

	/**
	 * weekdayOption
	 *
	 * @var integer
	 */
	protected $weekdayOption;

	/**
	 * allDay
	 *
	 * @var integer
	 */
	protected $allDay;

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
	 * @\TYPO3\CMS\Extbase\Annotation\ORM\Lazy
	 */
	protected $relatedDocuments;

	/**
	 * newsOption
	 *
	 * @var \integer
	 */
	protected $newsOption;

	/**
	 * newsText
	 *
	 * @var \string
	 */
	protected $newsText;

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
	 * Returns the dateStart
	 *
	 * @return \DateTime $dateStart
	 */
	public function getDateStart() {
		$timezone = new \DateTimeZone('Europe/Zurich');
		return $this->dateStart;
	}

	/**
	 * Sets the dateStart
	 *
	 * @param \DateTime $dateStart
	 * @return void
	 */
	public function setDateStart($dateStart) {
		$this->dateStart = $dateStart;
	}

	/**
	 * Returns the dateEnd
	 *
	 * @return \DateTime $dateEnd
	 */
	public function getDateEnd() {
		return $this->dateEnd;
	}

	/**
	 * Sets the dateEnd
	 *
	 * @param \DateTime $dateEnd
	 * @return void
	 */
	public function setDateEnd($dateEnd) {
		$this->dateEnd = $dateEnd;
	}

	/**
	 * Returns the timeStart
	 *
	 * @return \DateTime $timeStart
	 */
	public function getTimeStart() {
		return $this->timeStart;
	}

	/**
	 * Sets the timeStart
	 *
	 * @param \DateTime $timeStart
	 * @return void
	 */
	public function setTimeStart($timeStart) {
		$this->timeStart = $timeStart;
	}

	/**
	 * Returns the timeEnd
	 *
	 * @return \DateTime $timeEnd
	 */
	public function getTimeEnd() {
		return $this->timeEnd;
	}

	/**
	 * Sets the timeEnd
	 *
	 * @param \DateTime $timeEnd
	 * @return void
	 */
	public function setTimeEnd($timeEnd) {
		$this->timeEnd = $timeEnd;
	}

	/**
	 * Returns the interval
	 *
	 * @return integer $interval
	 */
	public function getInterval() {
		return $this->interval;
	}
	
	/**
	 * Sets the interval
	 *
	 * @param integer $interval
	 * @return void
	 */
	public function setInterval($interval) {
		$this->interval = $interval;
	}

	/**
	 * Returns the weekdayWeekly
	 *
	 * @return integer $weekdayWeekly
	 */
	public function getWeekdayWeekly() {
		return $this->weekdayWeekly;
	}
	
	/**
	 * Sets the weekdayWeekly
	 *
	 * @param integer $weekdayWeekly
	 * @return void
	 */
	public function setWeekdayWeekly($weekdayWeekly) {
		$this->weekdayWeekly = $weekdayWeekly;
	}

	/**
	 * Returns the weekdayMonthly
	 *
	 * @return integer $weekdayMonthly
	 */
	public function getWeekdayMonthly() {
		return $this->weekdayMonthly;
	}
	
	/**
	 * Sets the weekdayMonthly
	 *
	 * @param integer $weekdayMonthly
	 * @return void
	 */
	public function setWeekdayMonthly($weekdayMonthly) {
		$this->weekdayMonthly = $weekdayMonthly;
	}

	/**
	 * Returns the weekdayOption
	 *
	 * @return integer $weekdayOption
	 */
	public function getWeekdayOption() {
		return $this->weekdayOption;
	}
	
	/**
	 * Sets the weekdayOption
	 *
	 * @param integer $weekdayOption
	 * @return void
	 */
	public function setWeekdayOption($weekdayOption) {
		$this->weekdayOption = $weekdayOption;
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
	public function setRelatedDocuments(\FKU\FkuAgenda\Domain\Model\FileReference $relatedDocuments) {
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
	 * Returns the newsOption
	 *
	 * @return integer $newsOption
	 */
	public function getNewsOption() {
		return $this->newsOption;
	}
	
	/**
	 * Sets the newsOption
	 *
	 * @param integer $newsOption
	 * @return void
	 */
	public function setNewsOption($newsOption) {
		$this->newsOption = $newsOption;
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
	
}
?>