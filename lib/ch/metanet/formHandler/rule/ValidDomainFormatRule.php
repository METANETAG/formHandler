<?php

namespace ch\metanet\formHandler\rule;
use ch\metanet\formHandler\field\FormField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidDomainFormatRule extends Rule {
	/**
	 * @param FormField $field The field instance to check against
	 * @return bool
	 */
	public function validate(FormField $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fldValue = preg_replace(array('@^[a-z]+://@i', '@^www\.@i'), null, $field->getValue());

		if(strpos($fldValue, '.') === false)
			return false;

		return (filter_var('http://' . $fldValue, FILTER_VALIDATE_URL) !== false);
	}
}

/* EOF */ 