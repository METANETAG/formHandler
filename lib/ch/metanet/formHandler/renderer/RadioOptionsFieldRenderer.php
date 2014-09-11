<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class RadioOptionsFieldRenderer extends OptionsFieldRenderer {
	/**
	 * @param OptionsField $field
	 * @return string
	 * @throws \UnexpectedValueException
	 */
	public function render(OptionsField $field) {
		$required = ($field->hasRule('ch\metanet\formHandler\rule\RequiredRule') === true)?' aria-required="true"':null;
		$html = '<ul' . ((count($field->getCssClasses()) > 0)?' class="' . implode(' ', $field->getCssClasses()). '"':null) . '>';

		foreach($field->getOptions() as $key => $val) {
			$attrId = ' id="' . $field->getName() . '-' . $key . '"';
			$checked = ($key == $field->getValue())?' checked':null;
			$html .= '<li><label><input type="radio" name="' . $field->getName() . '" value="' . $key . '"' . $attrId . $checked . $required . '> ' . $val . '</label></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */