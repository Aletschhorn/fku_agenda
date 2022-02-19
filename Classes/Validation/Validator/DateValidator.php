<?php
namespace FKU\FkuAgenda\Validation\Validator;

class DateValidator extends TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
	public function isValid($value)
	{
		$this->errors = array();
		if (checkdate($value->format('n'),$value->format('j'),$value->format('Y'))) {
			return true;
		} else {
			$this->addError('The given date is not valid.', 43020001);
			return false;
		}
	}
}
?>