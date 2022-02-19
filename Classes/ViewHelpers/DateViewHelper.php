<?php
namespace FKU\FkuAgenda\ViewHelpers;

class DateViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Format\DateViewHelper {

    /**
     * Extends TYPO3 f:format.date viewhelper with utf8_encoding
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     *
     * @return string
     * @throws Exception
     */
	public static function renderStatic (array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext) {
		$return = parent::renderStatic ($arguments, $renderChildrenClosure, $renderingContext);
		return trim(utf8_encode($return));
	}
}

?>