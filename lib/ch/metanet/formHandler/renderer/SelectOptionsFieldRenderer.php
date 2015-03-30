<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class SelectOptionsFieldRenderer extends OptionsFieldRenderer
{
	/**
	 * @param OptionsField $field The OptionField to render
	 * @return string The HTML of the rendered select field
	 */
	public function render(OptionsField $field)
	{
		$required = ($field->hasRule('ch\metanet\formHandler\rule\RequiredRule') === true)?' aria-required="true"':null;

		$html = '<select name="' . $field->getFormIdentifierAsString() . '" id="' . $field->getName() . '"' . $this->getAttributesAsHtml() . $required . '>';

		$html .= $this->renderOptions($field->getOptions(), $field->getValue());

		$html .= '</select>';

		return $html;
	}

	/**
	 * @param array $options
	 * @param mixed $selection
	 *
	 * @return string
	 */
	protected function renderOptions(array $options, $selection)
	{
		$html = '';

		foreach($options as $key => $val) {
			if(is_array($val) === false) {
				$selected = ($key == $selection)?' selected':null;
				$html .= '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
			} else {
				$html .= '<optgroup label="' . $key . '">' . $this->renderOptions($val, $selection) . '</optgroup>';
			}
		}

		return $html;
	}
}

/* EOF */ 