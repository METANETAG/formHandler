<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class MinLengthRule extends Rule {
	protected $minLength;

	/**
	 * @param int $maxLength
	 * @param string $errorMessage
	 */
	function __construct($maxLength, $errorMessage) {
		parent::__construct($errorMessage);

		$this->minLength = $maxLength;
	}

	/**
	 * @param Field $field
	 * @return bool
	 * @throws \UnexpectedValueException
	 */
	public function validate(Field $field) {
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
		return ($valueLength >= $this->minLength);
	}
}

/* EOF */ 