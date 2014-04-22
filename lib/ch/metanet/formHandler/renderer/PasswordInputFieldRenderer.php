<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class PasswordInputFieldRenderer extends InputFieldRenderer {
	public function render(InputField $field) {
		return '<input type="password" name="' . $field->getName() . '" id="' . $field->getName() . '" value="' . $field->getValue() . '">';
	}
}

/* EOF */ 