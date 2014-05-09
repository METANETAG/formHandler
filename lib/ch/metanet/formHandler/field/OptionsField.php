<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\renderer\OptionsFieldRenderer;
use ch\metanet\formHandler\renderer\SelectOptionsFieldRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class OptionsField extends FormField {
	protected $options;
	protected $optionsFieldRenderer;
	protected $errorMessageInvalidOption;

	/**
	 * @param string $name
	 * @param string $label
	 * @param array $options
	 * @param array $ruleSet
	 */
	public function __construct($name, $label, array $options, array $ruleSet = array()) {
		parent::__construct($name, $label, $ruleSet);

		$this->options = $options;
		$this->optionsFieldRenderer = new SelectOptionsFieldRenderer();
		$this->linkedLabel = false;
		$this->errorMessageInvalidOption = 'Please choose a valid option';
	}

	public function render() {
		return $this->optionsFieldRenderer->render($this);
	}

	/**
	 * @return bool
	 */
	public function validate() {
		if($this->isValueEmpty() === false) {
			if($this->validateAgainstOptions() === false)
				return false;
		}

		return parent::validate();
	}

	protected function validateAgainstOptions() {
		if(is_scalar($this->value) === true) {
			if(($resCheck = array_key_exists($this->value, $this->options)) === false)
				$this->addError($this->errorMessageInvalidOption);

			return $resCheck;
		} elseif(is_array($this->value) === true) {
			foreach($this->value as $val) {
				if(array_key_exists($val, $this->options) === true)
					continue;

				$this->addError($this->errorMessageInvalidOption);

				return false;
			}
		} else {
			throw new \UnexpectedValueException('The field value is neither a scalar data type nor an array');
		}

		return true;
	}

	/**
	 * @param OptionsFieldRenderer $optionsFieldRenderer
	 */
	public function setOptionsFieldRenderer(OptionsFieldRenderer $optionsFieldRenderer) {
		$this->optionsFieldRenderer = $optionsFieldRenderer;
	}

	/**
	 * The
	 * @param array $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param mixed $errorMessageInvalidOption
	 */
	public function setErrorMessageInvalidOption($errorMessageInvalidOption) {
		$this->errorMessageInvalidOption = $errorMessageInvalidOption;
	}
}

/* EOF */ 