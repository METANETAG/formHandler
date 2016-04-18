<?php


namespace ch\metanet\formHandler\rule;

use ch\metanet\formHandler\field\Field;

/**
 * @copyright Copyright (c) 2016, METANET AG <entwicklung@metanet.ch>
 */
class NoArrayRule extends Rule
{
	/**
	 * @param Field $field
	 * 
	 * @return bool
	 * 
	 * @throws \UnexpectedValueException
	 */
	public function validate(Field $field)
	{
		return !is_array($field->getValue());
	}
}

/* EOF */