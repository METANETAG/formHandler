<?php


namespace ch\metanet\formHandler\rule;
use ch\metanet\formHandler\field\FormField;


/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidEmailAddressRule  extends Rule {
	protected $checkMx;

	function __construct($errorMessage, $checkMx = true) {
		parent::__construct($errorMessage);

		$this->checkMx = $checkMx;
	}

	/**
	 * @param FormField $field
	 * @return bool
	 */
	public function validate(FormField $field) {
		if($field->isValueEmpty() === true)
			return true;

		$fieldValue = $field->getValue();
		$emailValid = filter_var($fieldValue, FILTER_VALIDATE_EMAIL);

		if($emailValid === false)
			return false;

		if($this->checkMx === false)
			return true;

		$domain = substr($fieldValue, strrpos($fieldValue, '@') + 1);
		$mxRecords = array();

		return getmxrr(idn_to_ascii($domain), $mxRecords);
	}
}

/* EOF */ 