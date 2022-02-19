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
* Returns tag <td rowspan="x"> where x equals the size of given array
*
* @package fku_agenda
*/

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class TdRowspanViewHelper extends AbstractViewHelper {

    protected $escapeOutput = false;

    public function initializeArguments() {
        $this->registerArgument('array', 'array', 'Array or object of table columns in this row', true);
        $this->registerArgument('class', 'string', 'Class name of this column', false, NULL);
    }

	/**
     * Output of column tags
     *
    * @param \Closure $renderChildrenClosure
    * @param RenderingContextInterface $renderingContext
    * @return string
	*/
	public function render() {
		$array = $this->arguments['array'];
		if (is_array($array) or is_object($array)) {
			$content = $this->renderChildren();
			if ($class) {
				return '<td rowspan="'.count($array).'" class="'.$class.'">'.$content.'</td>';
			} else {
				return '<td rowspan="'.count($array).'">'.$content.'</td>';
			}
		} else {
			return '<td>'.$content.'</td>';
		}
	}
}
?>