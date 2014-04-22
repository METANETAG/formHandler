<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\field\FormField;
use ch\metanet\formHandler\FormHandler;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class FormFieldListener {
	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onEmptyValueBeforeValidation(FormHandler $formHandler, FormField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onEmptyValueAfterValidation(FormHandler $formHandler, FormField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onNotEmptyValueBeforeValidation(FormHandler $formHandler, FormField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onNotEmptyValueAfterValidation(FormHandler $formHandler, FormField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onValidationError(FormHandler $formHandler, FormField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FormField $field
	 */
	public function onValidationSuccess(FormHandler $formHandler, FormField $field) {

	}
}

/* EOF */