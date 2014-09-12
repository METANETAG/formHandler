<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class TextareaInputFieldRenderer extends InputFieldRenderer {
	public function render(InputField $field) {
		return '<textarea name="' . $field->getName() . '" id="' . $field->getName() . '"' . $this->getAttributesAsHtml() .  '>' . htmlspecialchars($field->getValue()) . '</textarea>';
	}
}

/* EOF */ 