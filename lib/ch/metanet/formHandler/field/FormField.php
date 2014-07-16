<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\decorator\FieldValueDecorator;
use ch\metanet\formHandler\FormHandler;
use ch\metanet\formHandler\listener\FormFieldListener;
use ch\metanet\formHandler\rule\Rule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class FormField {
	/** @var FormHandler */
	protected $formHandler;

	protected $name;
	protected $label;
	protected $ruleSet;
	protected $decorators;
	protected $checked;
	protected $errors;
	protected $value;
	protected $cssClasses;
	protected $linkedLabel;

	// Callbacks
	protected $listeners;

	/**
	 * @param string $name The name of the field in the HTTP request
	 * @param string $label The label of the field
	 * @param array $ruleSet
	 */
	public function __construct($name, $label, array $ruleSet = array()) {
		$this->name = $name;
		$this->label = $label;
		$this->ruleSet = $ruleSet;

		$this->errors = array();
		$this->checked = false;
		$this->value = null;
		$this->cssClasses = array();
		$this->listeners = array();
		$this->linkedLabel = true;
	}

	public abstract function render();

	public function validate() {
		foreach($this->ruleSet as $r) {
			/** @var Rule $r */
			if($r->validate($this) === true)
				continue;

			$this->errors[] = $r->getErrorMessage();
		}

		$this->checked = true;

		return !$this->hasErrors();
	}

	/**
	 * @return bool
	 * @throws \UnexpectedValueException
	 */
	public function isValueEmpty() {
		if($this->value === null)
			return true;

		if(is_scalar($this->value)) {
			return (mb_strlen($this->value) <= 0);
		} elseif(is_array($this->value)) {
			return (count($this->value) <= 0);
		} elseif($this->value instanceof \ArrayObject) {
			return ($this->value->count() <= 0);
		} else {
			throw new \UnexpectedValueException('Could not check value against emptiness');
		}
	}

	/**
	 * @param string $ruleClassName
	 * @return bool
	 */
	public function hasRule($ruleClassName) {
		foreach($this->ruleSet as $r) {
			if(get_class($r) === $ruleClassName)
				return true;
		}

		return false;
	}

	public function hasErrors() {
		return (count($this->errors) > 0);
	}

	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getRuleSet() {
		return $this->ruleSet;
	}

	/**
	 * @param Rule $rule
	 */
	public function addRule(Rule $rule) {
		$this->ruleSet[] = $rule;
	}

	/**
	 * @return array
	 */
	public function getDecorators() {
		return $this->decorators;
	}

	/**
	 * @param FieldValueDecorator $decorator
	 */
	public function addDecorator(FieldValueDecorator $decorator) {
		$this->decorators[] = $decorator;
	}

	/**
	 * @param array $ruleSet
	 * @param bool $override Override current rules for this field
	 */
	public function setRuleSet(array $ruleSet, $override = false) {
		if($override === true)
			$this->ruleSet = array();

		$this->ruleSet = array_merge($this->ruleSet, $ruleSet);
	}

	public function resetChecked() {
		$this->checked = false;
		$this->errors = array();
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @param string $errorMessage
	 */
	public function addError($errorMessage) {
		$this->errors[] = $errorMessage;

		if($this->formHandler instanceof FormHandler)
			$this->formHandler->addError($errorMessage);
	}

	/**
	 * @return boolean
	 */
	public function getChecked() {
		return $this->checked;
	}

	/**
	 * @return array
	 */
	public function getCssClasses() {
		return $this->cssClasses;
	}

	/**
	 * @param array $cssClasses
	 */
	public function setCssClasses(array $cssClasses) {
		$this->cssClasses = $cssClasses;
	}

	/**
	 * @param string $cssClass
	 */
	public function addCssClass($cssClass) {
		$this->cssClasses[] = $cssClass;
	}

	/**
	 * @param FormFieldListener $listener
	 */
	public function addListener(FormFieldListener $listener) {
		$this->listeners[] = $listener;
	}

	/**
	 * @return array
	 */
	public function getListeners() {
		return $this->listeners;
	}

	/**
	 * @param mixed $formHandler
	 */
	public function setFormHandler($formHandler) {
		$this->formHandler = $formHandler;
	}

	/**
	 * @param mixed $linkedLabel
	 */
	public function setLinkedLabel($linkedLabel) {
		$this->linkedLabel = $linkedLabel;
	}

	/**
	 * @return mixed
	 */
	public function getLinkedLabel() {
		return $this->linkedLabel;
	}
}

/* EOF */ 