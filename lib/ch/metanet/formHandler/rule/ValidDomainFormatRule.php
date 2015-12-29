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
	protected $ignoreSpaces;

	/**
	 * @param $errorMessage
	 * @param bool $publicTld
	 * @param bool $ignoreSpaces
	 */
	function __construct($errorMessage, $publicTld = true, $ignoreSpaces = true)
	{
		parent::__construct($errorMessage);

		$this->publicTld = $publicTld;
		$this->ignoreSpaces = $ignoreSpaces;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @return bool
	 */
	public function validate(Field $field)
	{
		if($field->isValueEmpty() === true)
			return true;

		$rplArr = array('/\xE2\x80\x8B/', '@^[a-z]+://@i', '@^www\.@i');

		if($this->ignoreSpaces) {
			$rplArr[] = '/ /';
		}
 
		$fldValue = preg_replace($rplArr, null, $field->getValue());

		if(($lastPoint = strrpos($fldValue, '.')) === false)
			return false;

		if($this->publicTld === true && strlen(substr($fldValue, $lastPoint + 1)) < 2)
			return false;

		return (filter_var('http://' . idn_to_ascii($fldValue), FILTER_VALIDATE_URL) !== false);
	}
}

/* EOF */