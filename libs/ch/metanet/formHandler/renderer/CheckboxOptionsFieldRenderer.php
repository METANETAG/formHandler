<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class CheckboxOptionsOptionsFieldRenderer extends OptionsFieldRenderer {
	/**
	 * @param OptionsField $field
	 * @return string
	 */
	public function render(OptionsField $field) {
		/** @var OptionsField $field */
		$fieldValue = is_array($field->getValue())?$field->getValue():array();
		$html = '<ul' . ((count($field->getCssClasses()) > 0)?' class="' . implode(' ', $field->getCssClasses()). '"':null) . '>';

		foreach($field->getOptions() as $key => $val) {
			$checked = in_array($key, $fieldValue)?' checked':null;
			$html .= '<li><label><input type="checkbox" name="' . $field->getName() . '[]" value="' . $key . '"' . $checked . '> ' . $val . '</label></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */