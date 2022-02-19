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
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
/*
use TYPO3Fluid\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
*/

class TodayEventsViewHelper extends AbstractViewHelper {
	
	use CompileWithRenderStatic;
    protected $escapeOutput = false;

    public function initializeArguments() {
        $this->registerArgument('day', 'integer', 'Day of the date', true);
        $this->registerArgument('month', 'integer', 'Month of the date', true);
        $this->registerArgument('each', 'array', 'The array or \SplObjectStorage to iterated over', true);
        $this->registerArgument('as', 'string', 'The name of the iteration variable', true);
        $this->registerArgument('needRooms', 'boolean', 'If TRUE then only events are considered that have rooms assigned', false, false);
    }

    /**
     * Output today events grouped
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

        $group = array();
        foreach ($each as $key => $value) {
			if ($arguments['needRooms'] == false or count($value->getRooms()) > 0) {
				$actualDate = date('md',mktime(0,0,0,$arguments['month'],$arguments['day']));
				if ($value->getEventStart()->format('md') <= $actualDate 
				and $value->getEventEnd()->format('md') >= $actualDate) {
					if ($arguments['needRooms'] == false or count($value->getRooms()) > 0) {
						$group[$key] = $value;
					}
				}
			}
		}

		$templateVariableContainer = $renderingContext->getVariableProvider();
		$output = '';
		$templateVariableContainer->add($arguments['as'], $group);
		$output .= $renderChildrenClosure();
		$templateVariableContainer->remove($arguments['as']);

		return $output;
	}
}
?>