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
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 */
	protected $title;

	/**
	 * acronym
	 *
	 * @var \string
	 */
	protected $acronym;

	/**
	 * duration
	 *
	 * @var \int
	 */
	protected $duration;

	/**
	 * detailsPid
	 *
	 * @var \int
	 */
	protected $detailsPid;

	/**
	 * hideInList
	 *
	 * @var boolean
	 */
	protected $hideInList;

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the acronym
	 *
	 * @return \string $acronym
	 */
	public function getAcronym() {
		return $this->acronym;
	}

	/**
	 * Sets the acronym
	 *
	 * @param \string $acronym
	 * @return void
	 */
	public function setAcronym($acronym) {
		$this->acronym = $acronym;
	}

	/**
	 * Returns the duration
	 *
	 * @return \int $duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Sets the duration
	 *
	 * @param \int $duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}

	/**
	 * Returns the detailsPid
	 *
	 * @return \int $detailsPid
	 */
	public function getDetailsPid() {
		return $this->detailsPid;
	}

	/**
	 * Sets the detailsPid
	 *
	 * @param \int $detailsPid
	 * @return void
	 */
	public function setDetailsPid($detailsPid) {
		$this->detailsPid = $detailsPid;
	}

	/**
	 * Returns the hideInList
	 *
	 * @return boolean $hideInList
	 */
	public function getHideInList() {
		return $this->hideInList;
	}

	/**
	 * Sets the hideInList
	 *
	 * @param boolean $hideInList
	 * @return void
	 */
	public function setHideInList($hideInList) {
		$this->hideInList = $hideInList;
	}
}
?>