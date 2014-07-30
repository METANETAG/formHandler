<?php


namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class RequiredRule extends Rule {
	/**
	 * @param Field $field
	 * @return bool|mixed
	 * @throws \UnexpectedValueException
	 */
	public function validate(Field $field) {
		return !$field->isValueEmpty();
	}
}

/* EOF */ 