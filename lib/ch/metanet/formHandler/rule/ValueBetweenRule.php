<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\FormField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValueBetweenRule extends Rule {
	protected $minValue;
	protected $maxValue;

	/**
	 * @param mixed $minValue The minimum allowed value
	 * @param mixed $maxValue The maximum allowed value
	 * @param string $errorMessage The error message on failure
	 */
	function __construct($minValue, $maxValue, $errorMessage) {
		parent::__construct($errorMessage);

		$this->minValue = $minValue;
		$this->maxValue = $maxValue;
	}

	/**
	 * @param FormField $field
	 * @return bool|mixed
	 * @throws \UnexpectedValueException
	 */
	public function validate(FormField $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();

		if(is_scalar($fieldValue) === true)
			return $this->checkValueBetweenScalar($fieldValue);
		elseif(is_array($fieldValue) === true || $fieldValue instanceof \ArrayObject)
			return $this->checkValueBetweenArray($fieldValue);
		else
			throw new \UnexpectedValueException('Could not handle field value for rule ' . __CLASS__);
	}

	private function checkValueBetweenScalar($value) {
		return ($value >= $this->minValue && $value <= $this->maxValue);
	}

	private function checkValueBetweenArray($value) {
		foreach($value as $val) {
			if(is_scalar($val) === true && $this->checkValueBetweenScalar($val) === false) {
				return false;
			} elseif((is_array($val) === true || $val instanceof \ArrayObject) && $this->checkValueBetweenArray($val) === false) {
				return false;
			}
		}

		return true;
	}
}

/* EOF */ 