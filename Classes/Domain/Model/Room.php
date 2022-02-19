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
class Room extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 */
	public $title;

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
	 * titleShort
	 *
	 * @var \string
	 */
	protected $titleShort;

	/**
	 * Returns the title
	 *
	 * @return \string $titleShort
	 */
	public function getTitleShort() {
		return $this->titleShort;
	}

	/**
	 * Sets the titleShort
	 *
	 * @param \string $titleShort
	 * @return void
	 */
	public function setTitleShort($titleShort) {
		$this->titleShort = $titleShort;
	}

	/**
	 * titleTiny
	 *
	 * @var \string
	 */
	protected $titleTiny;

	/**
	 * Returns the title
	 *
	 * @return \string $titleTiny
	 */
	public function getTitleTiny() {
		return $this->titleTiny;
	}

	/**
	 * Sets the titleTiny
	 *
	 * @param \string $titleTiny
	 * @return void
	 */
	public function setTitleTiny($titleTiny) {
		$this->titleTiny = $titleTiny;
	}

}
?>