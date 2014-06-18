<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class AttributesOptionsFieldRenderer extends OptionsFieldRenderer {
	/**
	 * @param OptionsField $field The field instance to render
	 * @return string The rendered field
	 */
	public function render(OptionsField $field) {
		$html = '<ul>';

		$fieldName = $field->getName();
		$fieldValue = $field->getValue();

		$defaultAttributes = array(
			'type' => 'radio',
			'name' => $fieldName,
			'value' => null
		);

		foreach($field->getOptions() as $value => $data) {
			$defaultAttributes['value'] = $value;
			$attributesStr = '';

			if(isset($data['attributes']) === true && is_array($data['attributes']) === true) {
				foreach(array_merge($defaultAttributes, $data['attributes']) as $name => $value) {
					$attributesStr .= ' ' . $name . '="' . (is_array($value)?implode(' ', $value):$value) . '"';
				}
			}

			$selected = ($value == $fieldValue)?' checked':null;

			$html .= '<li><label><input type="radio" name="' . $fieldName . '" value="' . $value . '"' . $attributesStr . $selected . '> ' . $data['label'] . '</label></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */ 