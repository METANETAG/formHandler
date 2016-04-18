<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\renderer\TextInputFieldRenderer;
use ch\metanet\formHandler\renderer\InputFieldRenderer;
use ch\metanet\formHandler\rule\NoArrayRule;

/**
 * @copyright Copyright (c) 2016, METANET AG <entwicklung@metanet.ch>
 */
class InputField extends Field
{
	protected $inputFieldRenderer;

	public function __construct($name, $label, array $ruleSet = array())
	{
		parent::__construct($name, $label, $ruleSet);
		$this->addRule(new NoArrayRule('Invalid value.'));

		$this->inputFieldRenderer = new TextInputFieldRenderer();
	}

	public function render()
	{
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
	public function setInputFieldRenderer(InputFieldRenderer $inputFieldRenderer)
	{
		$this->inputFieldRenderer = $inputFieldRenderer;
	}
}

/* EOF */