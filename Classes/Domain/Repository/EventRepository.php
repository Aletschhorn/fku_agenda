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
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	* defaultOrderings
	*
	* @var array
	*/
	protected $defaultOrderings = array('eventStart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
	
	/**
	* findByMonth
	*
	* @param \int $month Number (1..12) of month that shall be displayed
	* @param \int $year Number (e.g. 2014) of year that shall be displayed
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function findByMonth($month=1, $year=2014, $visible, $categoriesAll=1, $categoriesArray=array()) {

		$start = mktime(0,0,0,$month,1,$year);
		$end = strtotime('+1 months',$start);

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if ($categoriesAll == 0) {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventEnd',$start),
					$query->lessThan('eventStart',$end),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			)->execute();
		} else {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventEnd',$start),
					$query->lessThan('eventStart',$end),
					$query->in('visible',$visible)
				)
			)->execute();
		}
		return $result;
	}

	/**
	* findByInterval
	*
	* @param \timestamp $timestamp
	* @param \int $days Number of days to be added to the timestamp
	* @param \int $hours Number of hours to be added to the timestamp
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function findByInterval($timestamp, $days, $hours, $visible, $categoriesAll=1, $categoriesArray=array()) {

		$start = $timestamp;
		$end = strtotime('+'.intval($days).' days '.intval($hours).' hours',$start);

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if ($categoriesAll == 0) {
			$query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->lessThan('eventStart',$end),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			);
		} else {
			$query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->lessThan('eventStart',$end),
					$query->in('visible',$visible)
				)
			);
		}
		return $query->execute();
	}

	/**
	* findByYear
	*
	* @param \int $year
	* @param \array $visible
	* @return
	*/
	public function findByYear($year=2014, $visible=array()) {

		$start = mktime(0,0,0,1,1,$year);
		$end = strtotime('+1 years',$start);

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if (sizeof($visible) > 0) {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->lessThan('eventStart',$end),
					$query->in('visible',$visible)
				)
			)->execute();
		} else {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->lessThan('eventStart',$end)
				)
			)->execute();
		}
		return $result;
	}

	/**
	* findFuture
	*
	* @param \timestamp $timestamp Start date
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function findFuture($timestamp, $visible, $categoriesAll=1, $categoriesArray=array()) {

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if ($categoriesAll == 0) {
			$query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$timestamp),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			);
		} else {
			$query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$timestamp),
					$query->in('visible',$visible)
				)
			);
		}		
		return $query->execute();
	}


	/**
	* findPast
	*
	* @param \timestamp $timestamp End date
	* @return
	*/
	public function findPast($timestamp) {

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->lessThanOrEqual('eventStart',$timestamp));
		return $query->execute();
	}

	/**
	* findByUpdate
	*
	* @param \int $start Timestamp of oldest event to be looked for
	* @param \int $updateIntervalHours Number of hours since last update
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function findByUpdate($start, $updateIntervalHours, $visible, $categoriesAll=1, $categoriesArray=array()) {

		$update = strtotime('-'.$updateIntervalHours.' hours');

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if ($categoriesAll == 0) {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->greaterThanOrEqual('tstamp',$update),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			)->execute();
		} else {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->greaterThanOrEqual('tstamp',$update),
					$query->in('visible',$visible)
				)
			)->execute();
		}
		return $result;
	}

	/**
	* findNext
	*
	* @param \int $limit Number of events that shall be displayed
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function findNext($limit, $visible, $categoriesAll, $categoriesArray) {

		if ($limit < 1) { $limit = 1; }

		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		if ($categoriesAll == 0) {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventEnd',time()),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			)->setLimit($limit)->execute();
		} else {
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventEnd',time()),
					$query->in('visible',$visible)
				)
			)->setLimit($limit)->execute();
		}
		return $result;
	}

	/**
	* findLast
	*
	* @param \int $limit Number of events that shall be displayed
	* @param \array $visible Visibility uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category uids that shall be displayed
	* @param \bool $allPid Boolean Finds events indenpendent on PID	
	* @return
	*/
	public function findLast($limit, $visible, $categoriesAll, $categoriesArray, $allPid=0) {

		if ($limit < 1) { $limit = 1; }

		$query = $this->createQuery();
		if ($allPid) {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
		}
		if ($categoriesAll == 0) {
			$query->matching(
				$query->logicalAnd(
					$query->lessThanOrEqual('eventStart',time()),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			);
		} else {
			$query->matching(
				$query->logicalAnd(
					$query->lessThanOrEqual('eventStart',time()),
					$query->in('visible',$visible)
				)
			);
		}
		$query->setLimit($limit)->setOrderings(array('eventStart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute();
	}

	/**
	* findNews
	*
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @param \int $limit Number of events that shall be displayed, 0 = no limit
	* @return
	*/
	public function findNews($visible, $categoriesAll, $categoriesArray, $limit=0) {

		$query = $this->createQuery();
		if ($categoriesAll == 0) {
			$query->matching(
				$query->logicalAnd(
					$query->lessThanOrEqual('newsStart',time()),
					$query->greaterThan('newsEnd',time()),
					$query->in('visible',$visible),
					$query->in('category',$categoriesArray)
				)
			);
		} else {
			$query->matching(
				$query->logicalAnd(
					$query->lessThanOrEqual('newsStart',time()),
					$query->greaterThan('newsEnd',time()),
					$query->in('visible',$visible)
				)
			);
		}
		if ($limit > 0) {
			$query->setLimit($limit);
		}
		return $query->execute();
	}

	/**
	* findByDate
	*
	* @param \DateTime $date
	* @return
	*/
	public function findByDate($date) {
		$start = mktime(0,0,0,date('n',$date),date('j',$date),date('Y',$date));
		$end = strtotime('+1 days',$start);
		
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->greaterThanOrEqual('eventStart',$start),
				$query->lessThan('eventStart',$end)
			)
		)->execute();
	}

	/**
	* eventsPerDay
	*
	* @param \int $month
	* @param \int $year
	* @return
	*/
	public function eventsPerDay($month=1, $year=2014) {
		$start = mktime(0,0,0,$month,1,$year);
		$end = strtotime('+1 days',$start);
		
		$counter = array();
		$monat = $start;
		for ($i=1; $i<=date('t',$monat); $i++) {
			$query = $this->createQuery();
			$result = $query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual('eventStart',$start),
					$query->lessThan('eventStart',$end)
				)
			)->execute();
			$counter[$i] = sizeof($result);
			$start = $end;
			$end = strtotime('+1 days',$end);
		}
		
		return $counter;
	}
	
	/**
	* findPerSeries
	*
	* @param \FKU\FkuAgenda\Domain\Model\Series $series
	* @return
	*/
	public function findPerSeries(\FKU\FkuAgenda\Domain\Model\Series $series) {
		$query = $this->createQuery();
		return $query->matching($query->equals('series',$series))->execute();
	}
	
	/**
	* search
	*
	* @param \string $expression Search string
	* @param \bool $contains 0=event title starts with expression, 1=event titles contains expression
	* @param \int $category uid of category to limit event search
	* @param \int $daterangeStart timestamp of start of date range
	* @param \int $daterangeEnd timestamp of end of date range
	* @param \array $visible Visibility table uids that shall be displayed
	* @param \bool $categoriesAll Boolean value if all event categories shall be displayed
	* @param \array $categoriesArray Event category table uids that shall be displayed
	* @return
	*/
	public function search($expression, $contains, $category, $daterangeStart, $daterangeEnd, $visible, $categoriesAll, $categoriesArray) {
		$expression = trim($expression);
		if ($expression or $category) {
			$searchTerm = $expression.'%';
			if ($contains) {
				$searchTerm = '%'.$searchTerm;
			}

			$query = $this->createQuery();
			if ($category == 0 and $categoriesAll) {
				$result = $query->matching(
					$query->logicalAnd(
						$query->like('description',$searchTerm),
						$query->lessThanOrEqual('eventStart',$daterangeEnd),
						$query->greaterThanOrEqual('eventStart',$daterangeStart),
						$query->in('visible',$visible)
					)
				)->execute();
			} else {
				if ($category > 0) {
					$cat = array($category);
				} else {
					$cat = $categoriesArray;
				}
				$result = $query->matching(
					$query->logicalAnd(
						$query->like('description',$searchTerm),
						$query->in('category',$cat),
						$query->lessThanOrEqual('eventStart',$daterangeEnd),
						$query->greaterThanOrEqual('eventStart',$daterangeStart),
						$query->in('visible',$visible)
					)
				)->execute();
			}
			return $result;
		} else {
			return NULL;
		}
	}
	
	/**
	* getConfValue
	*
	* @param \string $bereich
	* @param \string $feld
	* @param \string $defaultValue
	* @return
	*/
	public function getConfValue($bereich, $feld, $defaultValue) {
		$retval = $this->pi_getFFvalue($this->cObj->data['pi_flexform'],$feld,$bereich); 
		if (!$retval) { $retval = $this->conf[$feld]; }
		if (!$retval) { $retval = $defaultValue; }
		return $retval;
	}

}
?>