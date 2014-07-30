<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidDomainFormatRule extends Rule {
	protected $publicTld;

	/**
	 * @param $errorMessage
	 * @param $publicTld
	 */
	function __construct($errorMessage, $publicTld = true) {
		parent::__construct($errorMessage);

		$this->publicTld = $publicTld;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @return bool
	 */
	public function validate(Field $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fldValue = preg_replace(array('@^[a-z]+://@i', '@^www\.@i'), null, $field->getValue());

		if(($lastPoint = strrpos($fldValue, '.')) === false)
			return false;

		if($this->publicTld === true && strlen(substr($fldValue, $lastPoint + 1)) < 2)
			return false;

		return (filter_var('http://' . idn_to_ascii($fldValue), FILTER_VALIDATE_URL) !== false);
	}
}

/* EOF */ 