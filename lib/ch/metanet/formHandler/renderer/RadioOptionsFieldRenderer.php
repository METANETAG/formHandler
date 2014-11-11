<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class RadioOptionsFieldRenderer extends OptionsFieldRenderer
{
	/**
	 * @param OptionsField $field
	 * @return string
	 * @throws \UnexpectedValueException
	 */
	public function render(OptionsField $field)
	{
		$required = ($field->hasRule('ch\metanet\formHandler\rule\RequiredRule') === true)?' aria-required="true"':null;
		$html = '<ul' . $this->getAttributesAsHtml() . '>';

		foreach($field->getOptions() as $key => $val) {
			$label = $val;
			$htmlAttributes = '';
			$htmlBefore = null;
			$htmlAfter = null;

			if(is_array($val) === true) {
				$label = $val['label'];
				$htmlAfter = isset($val['html_after'])?$val['html_after']:null;
				$htmlBefore = isset($val['html_before'])?$val['html_before']:null;

				if(isset($val['attributes']) === true) {
					foreach($val['attributes'] as $attrName => $attrValue) {
						$htmlAttributes .= ' ' . $attrName . '="' . $attrValue . '"';
					}
				}
			}

			$attrId = ' id="' . $field->getName() . '-' . $key . '"';
			$checked = ($key == $field->getValue())?' checked':null;
			$html .= '<li>' . $htmlBefore . '<label><input type="radio" name="' . $field->getName() . '" value="' . $key . '"' . $attrId . $checked . $htmlAttributes . $required . '> ' . $label . '</label>' . $htmlAfter . '</li>';
		}

		$html .= '</ul>';

		return $html;
	}
}

/* EOF */