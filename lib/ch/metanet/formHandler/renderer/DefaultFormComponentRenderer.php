<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\FormField;
use ch\metanet\formHandler\rule\RequiredRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class DefaultFormComponentRenderer extends FormComponentRenderer {
	public function render(FormField $field) {
		/** @var FormField $fld */
		$fldHtml = $field->render();

		$labelOpenTag = '<label>';
		$labelCloseTag = '</label>';
		$requiredStr = null;

		if($field->hasRule(RequiredRule::getClassName()) === true)
			$requiredStr = ' <abbr title="required">*</abbr>';

		if($field->getLinkedLabel() === true) {
			$labelOpenTag = '<label for="' . $field->getName() . '">';
		}

		$errorHtml = null;
		$cssClasses = array();

		if($field->hasErrors() === true) {
			$cssClasses[] = 'field-error';

			$errorHtml = '<div class="field-errors"><ul>';

			foreach($field->getErrors() as $error) {
				$errorHtml .= '<li>' . $error . '</li>';
			}

			$errorHtml .= '</ul></div>';
		}

		return '<dl' . ((count($cssClasses) > 0)?' class="' . implode(' ', $cssClasses) . '"':null) . '>
			<dt>' . $labelOpenTag . $field->getLabel() . $requiredStr . $labelCloseTag . '</dt>
			<dd>' . $fldHtml . $errorHtml . '</dd>
		</dl>';
	}
}

/* EOF */