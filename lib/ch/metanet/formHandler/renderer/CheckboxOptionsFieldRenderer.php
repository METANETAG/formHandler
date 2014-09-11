<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class CheckboxOptionsFieldRenderer extends OptionsFieldRenderer {
	/**
	 * @param OptionsField $field
	 * @return string
	 */
	public function render(OptionsField $field) {
		$required = ($field->hasRule('ch\metanet\formHandler\rule\RequiredRule') === true)?' aria-required="true"':null;
		$optionsCount = count($field->getOptions());

		$fieldValue = is_array($field->getValue())?$field->getValue():array();
		$html = '<ul' . ((count($field->getCssClasses()) > 0)?' class="' . implode(' ', $field->getCssClasses()). '"':null) . '>';
		$fieldName = ($optionsCount === 1)?$field->getName():$field->getName() . '[]';

		foreach($field->getOptions() as $key => $val) {
			$attrId = ' id="' . (($optionsCount === 1)?$field->getName():$field->getName() . '-' . $key) . '"';

			$checked = in_array($key, $fieldValue)?' checked':null;
			$html .= '<li><label><input type="checkbox" name="' . $fieldName . '" value="' . $key . '"' . $attrId . $checked . $required . '> ' . $val . '</label></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */