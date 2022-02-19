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
*/

class WeekdayCodeViewHelper extends AbstractViewHelper {
	
	use CompileWithRenderStatic;
    protected $escapeOutput = false;

    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('day', 'integer', 'Day of the date', true);
        $this->registerArgument('month', 'integer', 'Month of the date', true);
        $this->registerArgument('year', 'integer', 'Year of the date', true);
        $this->registerArgument('as', 'string', 'The name of the output variable', true);
    }

    /**
     * Output weekday of given date
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$date = mktime(0,0,0,$arguments['month'],$arguments['day'],$arguments['year']);
		if ($date) {
			$weekday = date('w',$date);

			$templateVariableContainer = $renderingContext->getVariableProvider();
			$templateVariableContainer->add($arguments['as'], $weekday);
			$output = $renderChildrenClosure();
			$templateVariableContainer->remove($arguments['as']);
			return $output;
			
		} else {
			return FALSE;
		}
	}

}
?>