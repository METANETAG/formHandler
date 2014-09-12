<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class SelectMultipleOptionsFieldRenderer extends OptionsFieldRenderer {
	function __construct()
	{
		$this->attributes = array('multiple' => null);
		$this->addLockedAttributes('multiple');
	}


	/**
	 * @param OptionsField $field
	 * @return string
	 */
	public function render(OptionsField $field)
	{
		/** @var OptionsField $field */
		$fieldValue = is_array($field->getValue())?$field->getValue():array();
		$html = '<select name="' . $field->getName() . '[]" id="' . $field->getName() . '"' . $this->getAttributesAsHtml() . '>';

		$html .= $this->renderOptions($field->getOptions(), $fieldValue);

		$html .= '</select>';

		return $html;
	}

	private function renderOptions(array $options, $fieldValue)
	{
		$html = '';

		foreach($options as $key => $val) {
			if(is_array($val) === true) {
				$html .= '<optgroup label="' . $key . '">' . $this->renderOptions($val, $fieldValue) . '</optgroup>';
			} else {
				$selected = in_array($key, $fieldValue)?' selected':null;
				$html .= '<option value="' . $key . '"' . $selected . '> ' . $val . '</option>';
			}
		}

		return $html;
	}
}

/* EOF */