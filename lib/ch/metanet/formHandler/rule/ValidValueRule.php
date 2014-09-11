<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class ValidValueRule extends Rule {
	protected $validValues;

	/**
	 * @param mixed $validValues
	 * @param string $errorMessage
	 */
	public function __construct($validValues, $errorMessage)
	{
		parent::__construct($errorMessage);
		
		$this->validValues = (array)$validValues;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @throws \UnexpectedValueException
	 * @return bool
	 */
	public function validate(Field $field)
	{
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();

		if(is_scalar($fieldValue) === true)
			return in_array($fieldValue, $this->validValues);
		elseif(is_array($fieldValue) === true || $fieldValue instanceof \ArrayObject)
			return (count(array_diff($fieldValue, $this->validValues)) === 0);
		else
			throw new \UnexpectedValueException('Could not handle field value for rule ' . __CLASS__);
	}
}

/* EOF */