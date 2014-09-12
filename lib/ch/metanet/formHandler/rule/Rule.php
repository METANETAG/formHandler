<?php

namespace ch\metanet\formHandler\rule;
use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class Rule {
	protected $errorMessage;

	public function __construct($errorMessage) {
		$this->errorMessage = $errorMessage;
	}

	/**
	 * @param Field $field The field instance to check against
	 * @return bool
	 */
	public abstract function validate(Field $field);

	/**
	 * @param string $errorMessage
	 */
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
	}

	/**
	 * The error message specified for this Rule instance
	 * @return string
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}
}

/* EOF */ 