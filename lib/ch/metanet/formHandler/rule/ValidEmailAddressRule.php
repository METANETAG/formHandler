<?php


namespace ch\metanet\formHandler\rule;
use ch\metanet\formHandler\field\FormField;


/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidEmailAddressRule  extends Rule {
	/**
	 * @param FormField $field
	 * @return bool
	 */
	public function validate(FormField $field) {
		if($field->isValueEmpty() === true)
			return true;

		return (filter_var($field->getValue(), FILTER_VALIDATE_EMAIL) !== false);
	}
}

/* EOF */ 