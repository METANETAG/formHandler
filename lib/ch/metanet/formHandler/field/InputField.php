<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\renderer\TextInputFieldRenderer;
use ch\metanet\formHandler\renderer\InputFieldRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class InputField extends Field {
	protected $inputFieldRenderer;

	public function __construct($name, $label, array $ruleSet = array()) {
		parent::__construct($name, $label, $ruleSet);

		$this->inputFieldRenderer = new TextInputFieldRenderer();
	}

	public function render() {
		return $this->fieldComponentRenderer->render($this, $this->inputFieldRenderer->render($this));
	}

	/**
	 * @return InputFieldRenderer
	 */
	public function getInputFieldRenderer()
	{
		return $this->inputFieldRenderer;
	}

	/**
	 * @param InputFieldRenderer $inputFieldRenderer
	 */
	public function setInputFieldRenderer(InputFieldRenderer $inputFieldRenderer) {
		$this->inputFieldRenderer = $inputFieldRenderer;
	}
}

/* EOF */