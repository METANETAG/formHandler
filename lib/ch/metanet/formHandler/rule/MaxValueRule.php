<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class MaxValueRule extends Rule
{
	protected $maxValue;

	/**
	 * @param mixed $maxValue
	 * @param string $errorMessage
	 */
	function __construct($maxValue, $errorMessage)
	{
		parent::__construct($errorMessage);

		$this->maxValue = $maxValue;
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
			return ($fieldValue >= $this->maxValue);
		else
			throw new \UnexpectedValueException('Could not handle field value for rule ' . __CLASS__);
	}
}

/* EOF */