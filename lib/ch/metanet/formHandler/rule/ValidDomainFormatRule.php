<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class ValidDomainFormatRule extends Rule
{
	protected $publicTld;
	protected $ignoreSurroundingSpaces;

	/**
	 * @param $errorMessage
	 * @param bool $publicTld
	 * @param bool $ignoreSurroundingSpaces
	 */
	function __construct($errorMessage, $publicTld = true, $ignoreSurroundingSpaces = true)
	{
		parent::__construct($errorMessage);

		$this->publicTld = $publicTld;
		$this->ignoreSurroundingSpaces = $ignoreSurroundingSpaces;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @return bool
	 */
	public function validate(Field $field)
	{
		if($field->isValueEmpty() === true)
			return true;
 
		$fldValue = $this->ignoreSurroundingSpaces ? trim($field->getValue()) : $field->getValue();
		$fldValue = preg_replace(array('/\xE2\x80\x8B/', '/ /', '@^[a-z]+://@i', '@^www\.@i'), null, $fldValue);

		if(($lastPoint = strrpos($fldValue, '.')) === false)
			return false;

		if($this->publicTld === true && strlen(substr($fldValue, $lastPoint + 1)) < 2)
			return false;

		return (filter_var('http://' . idn_to_ascii($fldValue), FILTER_VALIDATE_URL) !== false);
	}
}

/* EOF */