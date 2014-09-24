<?php


namespace ch\metanet\formHandler\rule;
use ch\metanet\formHandler\field\Field;


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
	 * @param Field $field
	 * @return bool
	 */
	public function validate(Field $field) {
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

		if(getmxrr(idn_to_ascii($domain), $mxRecords) === true)
			return true;

		// Port 25 fallback check if there's no MX record
		$aRecords = dns_get_record($domain, DNS_A);

		if(count($aRecords) <= 0)
			return false;

		$connection = @fsockopen($aRecords[0]['ip'], 25);

		if(is_resource($connection) === true) {
			fclose($connection);
			return true;
		}

		return false;
	}
}

/* EOF */ 