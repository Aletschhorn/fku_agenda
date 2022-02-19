<?php
namespace FKU\FkuAgenda\Validation\Validator;

class TimeValidator extends TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
	public function isValid($value)
	{
		$this->errors = array();
		$parts = explode(':',$value);
		if (is_numeric($parts[0]) and $parts[0]>=0 and $parts[0]<24 and is_numeric($parts[1]) and $parts[1]>=0 and $parts[1]<60) {
			return true;
		} else {
			$this->addError('The given time is not valid.', 43020002);
			return false;
		}
	}
}
?>