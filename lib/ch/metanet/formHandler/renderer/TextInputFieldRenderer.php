<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class TextInputFieldRenderer extends InputFieldRenderer {
	public function render(InputField $field) {
		$required = null;

		if($field->hasRule('ch\metanet\formHandler\rule\RequiredRule'))
			$required = ' aria-required="true"';
		
		return '<input type="text" name="' . $field->getFormIdentifierAsString() . '" id="' . $field->getId() . '" value="' . $field->getValue() . '"' . $required . '>';
	}
}

/* EOF */