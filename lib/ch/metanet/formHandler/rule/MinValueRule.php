<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class MinValueRule extends Rule {
	protected $minValue;

	/**
	 * @param mixed $minValue
	 * @param string $errorMessage
	 */
	function __construct($minValue, $errorMessage)
	{
		parent::__construct($errorMessage);

		$this->minValue = $minValue;
	}

	/**
	 * @param Field $field
	 * @return bool
	 * @throws \UnexpectedValueException
	 */
	public function validate(Field $field)
	{
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();

		if(is_scalar($fieldValue) === true)
			return ($fieldValue >= $this->minValue);
		else
			throw new \UnexpectedValueException('Could not handle field value for rule ' . __CLASS__);
	}
}

/* EOF */