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
* Returns ...
*
* @package fku_agenda
*/

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
/*
use TYPO3Fluid\Fluid\Core\ViewHelper\Facets\CompilableInterface;
*/

class GroupedByMonthDayViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;
    protected $escapeOutput = false;

    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('each', 'array', 'The array or \SplObjectStorage to iterated over', true);
        $this->registerArgument('as', 'string', 'The name of the iteration variable', true);
        $this->registerArgument('keyMonth', 'string', 'The variable with the number of current month', false, 'eventMonth');
        $this->registerArgument('keyDay', 'string', 'The variable with the number of current day', false, 'eventDay');
    }


    /**
     * Output events grouped by month
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
			$currentDayIndex = $value->eventStart->format('j');
			$currentMonthIndex = $value->eventStart->format('n');
            $groups['keyMonth'][$currentMonthIndex] = $currentMonthIndex;
            $groups['keyDay'][$currentDayIndex] = $currentDayIndex;
            $groups['values'][$currentMonthIndex][$currentDayIndex][$key] = $value;
        }

		$templateVariableContainer = $renderingContext->getVariableProvider();
		$output = '';
        foreach ($groups['values'] as $currentMonthIndex => $groupMonth) {
			foreach ($groupMonth as $currentDayIndex => $groupDay) {
				$templateVariableContainer->add($arguments['keyMonth'], $groups['keys'][$currentMonthIndex]);
				$templateVariableContainer->add($arguments['keyDay'], $groups['keys'][$currentDayIndex]);
				$templateVariableContainer->add($arguments['as'], $groupDay);
				$output .= $renderChildrenClosure();
				$templateVariableContainer->remove($arguments['keyMonth']);
				$templateVariableContainer->remove($arguments['keyDay']);
				$templateVariableContainer->remove($arguments['as']);
			}
		}

		return $output;
	}
}
?>