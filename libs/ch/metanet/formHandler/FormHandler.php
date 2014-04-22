<?php

namespace ch\metanet\formHandler;

use ch\metanet\formHandler\field\FormField;
use ch\metanet\formHandler\field\FormFieldLabeled;
use ch\metanet\formHandler\rule\RequiredRule;

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

	public function __construct($method = self::METHOD_POST, $sentVar = 'send') {
		$this->fields = array();

		$this->method = $method;
		$this->submitLabel = 'send';
		$this->sentVar = $sentVar;
		$this->inputData = array();
	}

	public function render() {
		$formHtml = '<form action="?send" method="' . $this->method . '">';

		foreach($this->fields as $fld) {
			$formHtml .= $this->renderField($fld);
		}

		$formHtml .= '
			<div class="submit">
				<input type="submit" value="' . $this->submitLabel . '">
			</div>
		</form>';

		return $formHtml;
	}

	public function renderField(FormField $field) {
		/** @var FormField $fld */
		$fldHtml = $field->render();

		$labelOpenTag = '<label>';
		$labelCloseTag = '</label>';
		$requiredStr = null;

		if($field->hasRule(RequiredRule::getClassName()) === true)
			$requiredStr = '<abbr title="required">*</abbr>';

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

	public function isSent() {
		return (array_key_exists($this->sentVar, $this->inputData));
	}

	public function validate() {
		$valid = true;

		foreach($this->fields as $fld) {
			/** @var FormField $fld */
			if(($validationResult = $fld->validate()) === false)
				$valid = $validationResult;

			$isValueEmpty = $fld->isValueEmpty();

			foreach($fld->getListeners() as $l) {
				/** @var FormFieldListener $l */
				if($isValueEmpty === true) {
					$l->onEmptyValue($this, $fld);
				} else {
					$l->onNotEmptyValue($this, $fld);
				}
			}
		}

		return $valid;
	}

	/**
	 * @param array $data
	 */
	public function setInputData(array $data) {
		$this->inputData = $data;
	}

	/**
	 * @param array $fields
	 */
	public function setFields($fields) {
		foreach($fields as $fld)
			$this->addField($fld);
	}

	public function addField(FormField $field) {
		if(array_key_exists($field->getName(), $this->inputData) === true)
			$field->setValue($this->inputData[$field->getName()]);

		$field->setFormHandler($this);

		$this->fields[] = $field;
	}

	/**
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	public function getFieldsKeyValueMap() {
		$fldsKeyValueMap = array();

		foreach($this->fields as $fld) {
			$fldsKeyValueMap[$fld->getName()] = $fld->getValue();
		}

		return $fldsKeyValueMap;
	}
}

/* EOF */ 