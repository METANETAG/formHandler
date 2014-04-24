<?php

namespace ch\metanet\formHandler;

use ch\metanet\formHandler\field\FormField;
use ch\metanet\formHandler\field\FormFieldLabeled;
use ch\metanet\formHandler\listener\FormFieldListener;
use ch\metanet\formHandler\renderer\DefaultFormComponentRenderer;
use ch\metanet\formHandler\renderer\FormComponentRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FormHandler {
	const METHOD_POST = 'post';
	const METHOD_GET = 'get';

	protected $fields;
	protected $method;
	protected $action;
	protected $submitLabel;
	protected $inputData;
	protected $sentVar;
	protected $errors;

	protected $formComponentRenderer;

	/**
	 * @param string $method
	 * @param string $sentVar The name of the variable to recognize that the form has been sent to the server
	 */
	public function __construct($method = self::METHOD_POST, $sentVar = 'send') {
		$this->fields = array();

		$this->method = $method;
		$this->submitLabel = 'send';
		$this->sentVar = $sentVar;
		$this->inputData = array();
		$this->errors = array();

		$this->formComponentRenderer = new DefaultFormComponentRenderer();
	}

	/**
	 * Renders the whole form including submit button, all form components and the form tag itself
	 * @return string The HTML code for this form
	 */
	public function render() {
		$formHtml = '<form action="?send" method="' . $this->method . '">';

		foreach($this->fields as $fld) {
			$formHtml .= $this->renderFormComponent($fld);
		}

		$formHtml .= '
			<div class="submit">
				<input type="submit" value="' . $this->submitLabel . '">
			</div>
		</form>';

		return $formHtml;
	}

	/**
	 * @param FormField $field
	 * @return string
	 */
	public function renderFormComponent(FormField $field) {
		return $this->formComponentRenderer->render($field);
	}

	/**
	 * Checks if the form has been sent to the server
	 * @return bool
	 */
	public function isSent() {
		return array_key_exists($this->sentVar, $this->inputData);
	}

	/**
	 * Validates the form and the connected fields against the field rules
	 * @return bool
	 */
	public function validate() {
		$valid = true;
		$this->errors = array();

		foreach($this->fields as $fld) {
			/** @var FormField $fld */
			if(($validationResult = $fld->validate()) === false) {
				$valid = $validationResult;
				$this->errors = array_merge($this->errors, $fld->getErrors());
			}

			$isValueEmpty = $fld->isValueEmpty();

			foreach($fld->getListeners() as $l) {
				/** @var FormFieldListener $l */
				if($isValueEmpty === true) {
					$l->onEmptyValueAfterValidation($this, $fld);
				} else {
					$l->onNotEmptyValueAfterValidation($this, $fld);
				}
			}
		}

		return $valid;
	}

	/**
	 * @return bool
	 */
	public function hasErrors() {
		return (count($this->errors) > 0);
	}

	/**
	 * Returns all the current error messages of all connected fields occurred during last validation
	 * @return array The error messages
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Sets the input data to fill and validate the connected form fields against
	 * @param array $data The input data (e.x. $_GET, $_POST, $_FILES or a merged array)
	 */
	public function setInputData(array $data) {
		$this->inputData = $data;
	}

	/**
	 * Connects an undefined amount of form fields with this form handler instance
	 * @param array $fields The array with form fields to be connected
	 */
	public function setFields(array $fields) {
		foreach($fields as $fld)
			$this->addField($fld);
	}

	/**
	 * Connects a field with the form handler instance
	 * @param FormField $field The form field to add
	 */
	public function addField(FormField $field) {
		if($this->isSent() === true) {
			if(array_key_exists($field->getName(), $this->inputData) === true)
				$field->setValue($this->inputData[$field->getName()]);
			else
				$field->setValue(null);
		}

		$field->setFormHandler($this);

		$this->fields[$field->getName()] = $field;
	}

	/**
	 * Returns all connected fields for this form handler instance
	 * @return array All connected fields of this form handler instance
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Returns a connected form field of this form handler instance selected by its name
	 * @param string $name The name of the connected form field
	 * @return FormField The form field
	 * @throws \UnexpectedValueException
	 */
	public function getField($name) {
		if(isset($this->fields[$name]) === false)
			throw new \UnexpectedValueException('The field with name "' . $name . '" does not exist');

		return $this->fields[$name];
	}

	/**
	 * Returns a key value map of all connected fields. Where the field name is the key and its current data the value.
	 * @return array A key value map of all the fields connected to this form handler instance
	 */
	public function getFieldsAsKeyValueMap() {
		$fldsKeyValueMap = array();

		foreach($this->fields as $fld) {
			$fldsKeyValueMap[$fld->getName()] = $fld->getValue();
		}

		return $fldsKeyValueMap;
	}

	/**
	 * @param FormComponentRenderer $formComponentRenderer
	 */
	public function setFormComponentRenderer(FormComponentRenderer $formComponentRenderer) {
		$this->formComponentRenderer = $formComponentRenderer;
	}
}

/* EOF */ 