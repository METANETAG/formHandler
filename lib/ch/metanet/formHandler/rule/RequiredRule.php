<?php


namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\FormField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class RequiredRule extends Rule {
	/**
	 * @param FormField $field
	 * @return bool|mixed
	 * @throws \UnexpectedValueException
	 */
	public function validate(FormField $field) {
		return !$field->isValueEmpty();
	}
}

/* EOF */ 