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
	/** @var  OptionsFieldRenderer */
	protected $fieldRenderer;

	/**
	 * @param string $name
	 * @param string $label
	 * @param array $options
	 * @param array $ruleSet
	 */
	public function __construct($name, $label, array $options, array $ruleSet = array()) {
		parent::__construct($name, $label, $ruleSet);

		$this->options = $options;
		$this->fieldRenderer = new SelectOptionsFieldRenderer();
		$this->linkedLabel = false;
	}

	public function render() {
		return $this->fieldRenderer->render($this);
	}

	/**
	 * @param OptionsFieldRenderer $fieldRenderer
	 */
	public function setFieldRenderer(OptionsFieldRenderer $fieldRenderer) {
		$this->fieldRenderer = $fieldRenderer;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		if($value === null)
			$this->value = null;
		elseif($this->isValueEmpty() === true)
			$this->value = array();
		else
			$this->value = is_array($value)?$value:array($value);
	}

	/**
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
}

/* EOF */ 