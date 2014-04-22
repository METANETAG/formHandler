<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class NumberInputFieldRenderer extends InputFieldRenderer {
	protected $step;
	protected $min;
	protected $max;

	public function __construct($step = null, $min = null, $max = null) {
		$this->step = $step;
		$this->min = $min;
		$this->max = $max;
	}

	public function render(InputField $field) {
		$minAttr = ($this->min !== null)?' min="' . $this->min . '"':null;
		$maxAttr = ($this->max !== null)?' max="' . $this->max . '"':null;
		$stepAttr = ($this->step !== null)?' step="' . $this->step . '"':null;

		return '<input type="number" name="' . $field->getName() . '" id="' . $field->getName() . '" value="' . $field->getValue() . '"' . $minAttr . $maxAttr . $stepAttr . '>';
	}
}

/* EOF */ 