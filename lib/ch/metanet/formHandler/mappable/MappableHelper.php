<?php

namespace ch\metanet\formHandler\mappable;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
class MappableHelper
{
	public static function setPropertyValue($instance, $propertyName, $value)
	{
		
	}
	
	public static function getPropertyValue($instance, $propertyName)
	{
		$refProp = new \ReflectionProperty($instance, $propertyName);

		if($refProp->isPublic() === false)
			$refProp->setAccessible(true);

		$value = $refProp->getValue($instance);

		if($refProp->isPublic() === false)
			$refProp->setAccessible(false);
		
		return $value;
	}
}

/* EOF */