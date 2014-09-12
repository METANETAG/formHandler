<?php

namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class FloatValueRule extends Rule {
	
	/**
	 * @param Field $field The field instance to check against
	 * @return bool
	 */
	public function validate(Field $field)
	{
		if($field->isValueEmpty() === true)
			return true;
		
		return (
			filter_var($field->getValue(), FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND) !== false || 
			filter_var($field->getValue(), FILTER_VALIDATE_FLOAT, array(
				'flags' => FILTER_FLAG_ALLOW_THOUSAND, 
				'options' => array('decimal' => ',')
			)) !== false
		);
	}
}

/* EOF */ 