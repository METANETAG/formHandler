<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\DateField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class TextDateFieldRenderer extends DateFieldRenderer
{
	/**
	 * @param DateField $field The field instance to render
	 * @return string The rendered field
	 */
	public function render(DateField $field)
	{
		if(is_array($field->getValue()) === true) {
			$field->setValue(null);
		}

		return '<input type="text" value="' . htmlspecialchars($field->getValue()) . '" name="' . $field->getFormIdentifierAsString() . '" id="' . $field->getName() . '"' . $this->getAttributesAsHtml() . '>';
	}
}

/* EOF */