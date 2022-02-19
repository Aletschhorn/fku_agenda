<?php

namespace FKU\FkuAgenda\Tests;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \FKU\FkuAgenda\Domain\Model\Event.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage FKU Agenda
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class EventTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \FKU\FkuAgenda\Domain\Model\Event
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \FKU\FkuAgenda\Domain\Model\Event();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getEventStartReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEventStartForDateTimeSetsEventStart() { }
	
	/**
	 * @test
	 */
	public function getEventEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEventEndForDateTimeSetsEventEnd() { }
	
	/**
	 * @test
	 */
	public function getLinkReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLinkForStringSetsLink() { 
		$this->fixture->setLink('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLink()
		);
	}
	
	/**
	 * @test
	 */
	public function getRelatedDocumentsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setRelatedDocumentsForStringSetsRelatedDocuments() { 
		$this->fixture->setRelatedDocuments('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getRelatedDocuments()
		);
	}
	
	/**
	 * @test
	 */
	public function getNewsStartReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setNewsStartForDateTimeSetsNewsStart() { }
	
	/**
	 * @test
	 */
	public function getNewsEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setNewsEndForDateTimeSetsNewsEnd() { }
	
	/**
	 * @test
	 */
	public function getNewsTextReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNewsTextForStringSetsNewsText() { 
		$this->fixture->setNewsText('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getNewsText()
		);
	}
	
	/**
	 * @test
	 */
	public function getRoomsReturnsInitialValueForRoom() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRooms()
		);
	}

	/**
	 * @test
	 */
	public function setRoomsForObjectStorageContainingRoomSetsRooms() { 
		$room = new \FKU\FkuAgenda\Domain\Model\Room();
		$objectStorageHoldingExactlyOneRooms = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneRooms->attach($room);
		$this->fixture->setRooms($objectStorageHoldingExactlyOneRooms);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRooms,
			$this->fixture->getRooms()
		);
	}
	
	/**
	 * @test
	 */
	public function addRoomToObjectStorageHoldingRooms() {
		$room = new \FKU\FkuAgenda\Domain\Model\Room();
		$objectStorageHoldingExactlyOneRoom = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneRoom->attach($room);
		$this->fixture->addRoom($room);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRoom,
			$this->fixture->getRooms()
		);
	}

	/**
	 * @test
	 */
	public function removeRoomFromObjectStorageHoldingRooms() {
		$room = new \FKU\FkuAgenda\Domain\Model\Room();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($room);
		$localObjectStorage->detach($room);
		$this->fixture->addRoom($room);
		$this->fixture->removeRoom($room);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getRooms()
		);
	}
	
	/**
	 * @test
	 */
	public function getResourcesReturnsInitialValueForResource() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function setResourcesForObjectStorageContainingResourceSetsResources() { 
		$resource = new \FKU\FkuAgenda\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResources = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResources->attach($resource);
		$this->fixture->setResources($objectStorageHoldingExactlyOneResources);

		$this->assertSame(
			$objectStorageHoldingExactlyOneResources,
			$this->fixture->getResources()
		);
	}
	
	/**
	 * @test
	 */
	public function addResourceToObjectStorageHoldingResources() {
		$resource = new \FKU\FkuAgenda\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResource = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResource->attach($resource);
		$this->fixture->addResource($resource);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneResource,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function removeResourceFromObjectStorageHoldingResources() {
		$resource = new \FKU\FkuAgenda\Domain\Model\Resource();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($resource);
		$localObjectStorage->detach($resource);
		$this->fixture->addResource($resource);
		$this->fixture->removeResource($resource);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getResources()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoryReturnsInitialValueForCategory() { }

	/**
	 * @test
	 */
	public function setCategoryForCategorySetsCategory() { }
	
	/**
	 * @test
	 */
	public function getVisibleReturnsInitialValueForVisibilityCategory() { }

	/**
	 * @test
	 */
	public function setVisibleForVisibilityCategorySetsVisible() { }
	
}
?>