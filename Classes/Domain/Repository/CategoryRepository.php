<?php
namespace FKU\FkuAgenda\Domain\Repository;
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
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	/**
	* defaultOrderings
	*
	* @var array
	*/
	protected $defaultOrderings = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);

	/**
	* findByUids
	*
	* @param \array $uids Array of UID values
	* @return
	*/
	public function findByUids($uids) {
		$query = $this->createQuery();
		$result = $query->matching($query->in('uid',$uids))->execute();
		return $result;
	}

	/**
	* findforList
	*
	* @return
	*/
	public function findForList() {
		$query = $this->createQuery();
		$result = $query->matching($query->equals('hideInList',0))->setOrderings(['acronym' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING])->execute();
		return $result;
	}

}
?>