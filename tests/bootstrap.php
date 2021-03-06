<?php

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
require_once __DIR__ . '/../vendor/autoload.php';

// Mock for idn_to_ascii function for PHP bins compiled without the --intl flag
if(function_exists('idn_to_ascii') === false) {
	echo 'Mocked up function: idn_to_ascii' , PHP_EOL;

	function idn_to_ascii($idn) {
		return $idn;
	}
}