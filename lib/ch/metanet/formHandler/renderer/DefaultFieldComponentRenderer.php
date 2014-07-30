<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\Field;
use ch\metanet\formHandler\rule\RequiredRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class DefaultFieldComponentRenderer extends FieldComponentRenderer {
	public function render(Field $field, $renderedField) {
		$labelOpenTag = '<label>';
		$labelCloseTag = '</label>';
		$requiredStr = null;

		if($field->hasRule('ch\metanet\formHandler\rule\RequiredRule') === true)
			$requiredStr = ' <abbr title="required">*</abbr>';

		if($field->getLinkedLabel() === true) {
			$labelOpenTag = '<label for="' . $field->getId() . '">';
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
			<dd>' . $renderedField . $errorHtml . '</dd>
		</dl>';
	}
}

/* EOF */