<?php
namespace FKU\FkuAgenda\ViewHelpers;

/***************************************************************
*  Copyright notice
*
*  (c) 2014 Daniel Widmer <daniel.widmer@fku.ch>
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
* @package fku_agenda
*/

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
/*
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\Facets\CompilableInterface;
*/

class GroupedByDayViewHelper extends AbstractViewHelper {
	
	use CompileWithRenderStatic;
    protected $escapeOutput = false;

    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('each', 'array', 'The array or \SplObjectStorage to iterated over', true);
        $this->registerArgument('as', 'string', 'The name of the iteration variable', true);
        $this->registerArgument('groupKey', 'string', 'The name of the variable to store the current group', false, 'eventStartDay');
        $this->registerArgument('severalDays', 'boolean', 'If TRUE then a separate group for event that go over several days is created', false, true);
        $this->registerArgument('needRooms', 'boolean', 'If TRUE then only events are considered that have rooms assigned', false, false);
    }

    /**
     * Output events grouped by day
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
				
		$each = $arguments['each'];
        if ($each === NULL) {
            return '';
		}
 
        if (is_object($each)) {
            $each = iterator_to_array($each);
        }

        $groups = array('keys' => array(), 'values' => array());
        foreach ($each as $key => $value) {
			if ($arguments['needRooms'] == false or sizeof($value->roomArray) > 0) {
				if ($arguments['severalDays']) {
					$currentGroupIndex = $value->getEventStart()->format('j') . '-' . $value->getSeveralDays();
				} else {
					$currentGroupIndex = $value->getEventStart()->format('j');
				}
				$groups['keys'][$currentGroupIndex] = $currentGroupIndex;
				$groups['values'][$currentGroupIndex][$key] = $value;
			}
        }
		
		$templateVariableContainer = $renderingContext->getVariableProvider();
		$output = '';
        foreach ($groups['values'] as $currentGroupIndex => $group) {
			$templateVariableContainer->add($arguments['groupKey'], $groups['keys'][$currentGroupIndex]);
			$templateVariableContainer->add($arguments['as'], $group);
			$output .= $renderChildrenClosure();
			$templateVariableContainer->remove($arguments['groupKey']);
			$templateVariableContainer->remove($arguments['as']);
		}

		return $output;
	}
}
?>