<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class SelectOptionsFieldRenderer extends OptionsFieldRenderer {
	/**
	 * @param OptionsField $field The OptionField to render
	 * @return string The HTML of the rendered select field
	 */
	public function render(OptionsField $field) {
		$html = '<select name="' . $field->getName() . '" id="' . $field->getName() . '"' . ((count($field->getCssClasses()) > 0)?' class="' . implode(' ', $field->getCssClasses()). '"':null) . '>';

		foreach($field->getOptions() as $key => $val) {
			$selected = ($key == $field->getValue())?' selected':null;
			$html .= '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
		}

		$html .= '</select>';

		return $html;
	}
}

/* EOF */ 