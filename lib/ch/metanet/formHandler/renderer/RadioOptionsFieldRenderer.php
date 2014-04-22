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
		if(($field instanceof OptionsField) === false)
			throw new \UnexpectedValueException('Only objects of instance OptionsField are allowed');

		$html = '<ul' . ((count($field->getCssClasses()) > 0)?' class="' . implode(' ', $field->getCssClasses()). '"':null) . '>';

		foreach($field->getOptions() as $key => $val) {
			$checked = ($key == $field->getValue())?' checked':null;
			$html .= '<li><label><input type="radio" name="' . $field->getName() . '" value="' . $key . '"' . $checked . '> ' . $val . '</label></li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */