<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\FormField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class MaxLengthRule extends Rule {
	protected $maxLength;

	/**
	 * @param int $maxLength
	 * @param string $errorMessage
	 */
	function __construct($maxLength, $errorMessage) {
		parent::__construct($errorMessage);

		$this->maxLength = $maxLength;
	}

	/**
	 * @param FormField $field
	 * @return bool
	 * @throws \UnexpectedValueException
	 */
	public function validate(FormField $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();

		if(is_scalar($fieldValue) === true)
			return $this->checkValueLengthAgainst(mb_strlen($fieldValue));
		elseif(is_array($fieldValue) === true)
			return $this->checkValueLengthAgainst(count($fieldValue));
		elseif($fieldValue instanceof \ArrayObject)
			return $this->checkValueLengthAgainst($fieldValue->count());
		else
			throw new \UnexpectedValueException('Could not handle field value for rule ' . __CLASS__);
	}

	private function checkValueLengthAgainst($valueLength) {
		return ($valueLength <= $this->maxLength);
	}
}

/* EOF */ 