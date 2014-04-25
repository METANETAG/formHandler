<?php

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib';
set_include_path($path . PATH_SEPARATOR . get_include_path());

spl_autoload_register(function($className) {
	$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
	$filePath = stream_resolve_include_path($fileName);

	if($filePath !== false) {
		require $filePath;

		return true;
	}

	return false;
});
 
/* EOF */