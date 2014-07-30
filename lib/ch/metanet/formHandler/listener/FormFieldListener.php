<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\component\Component;
use ch\metanet\formHandler\component\Form;
use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class FormFieldListener {
	/**
	 * @param Form $formHandler
	 * @param Component $component
	 */
	public function onEmptyValueBeforeValidation(Form $formHandler, Component $component) {

	}

	/**
	 * @param Form $formHandler
	 * @param Component $component
	 */
	public function onEmptyValueAfterValidation(Form $formHandler, Component $component) {

	}

	/**
	 * @param Form $formHandler
	 * @param Component $component
	 */
	public function onNotEmptyValueBeforeValidation(Form $formHandler, Component $component) {

	}

	/**
	 * @param Form $formHandler
	 * @param Component $component
	 */
	public function onNotEmptyValueAfterValidation(Form $formHandler, Component $component) {

	}

	/**
	 * @param Form $formHandler
	 * @param Component $component
	 */
	public function onValidationError(Form $formHandler, Component $component) {

	}

	/**
	 * @param Form $formHandler
	 * @param Field $field
	 */
	public function onValidationSuccess(Form $formHandler, Field $field) {

	}
}

/* EOF */