<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class RegexRule extends Rule {
	protected $pattern;

	/**
	 * @param string $pattern The pattern to check against
	 * @param string $errorMessage The error message if validation fails
	 */
	public function __construct($pattern, $errorMessage) {
		parent::__construct($errorMessage);

		$this->pattern = $pattern;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @throws \UnexpectedValueException
	 * @return bool
	 */
	public function validate(Field $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();

		if(is_scalar($fieldValue) === true) {
			return $this->checkAgainstPattern($fieldValue);
		} elseif(is_array($fieldValue) === true || $fieldValue instanceof \ArrayObject) {
			foreach($fieldValue as $value) {
				if($this->checkAgainstPattern($value) === false)
					return false;
			}

			return true;
		} else {
			throw new \UnexpectedValueException('The field value is neither scalar nor an array');
		}
	}

	protected function checkAgainstPattern($value) {
		return (preg_match($this->pattern, $value) === 1);
	}
}

/* EOF */