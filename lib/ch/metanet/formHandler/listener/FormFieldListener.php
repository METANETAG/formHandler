<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\component\Form;
use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class FormFieldListener
{
	/**
	 * @param Form $formHandler
	 * @param Field $component
	 */
	public function onEmptyValueBeforeValidation(Form $formHandler, Field $component)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param Field $component
	 */
	public function onEmptyValueAfterValidation(Form $formHandler, Field $component)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param Field $component
	 */
	public function onNotEmptyValueBeforeValidation(Form $formHandler, Field $component)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param Field $component
	 */
	public function onNotEmptyValueAfterValidation(Form $formHandler, Field $component)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param Field $component
	 */
	public function onValidationError(Form $formHandler, Field $component)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param Field $field
	 */
	public function onValidationSuccess(Form $formHandler, Field $field)
	{

	}
}

/* EOF */