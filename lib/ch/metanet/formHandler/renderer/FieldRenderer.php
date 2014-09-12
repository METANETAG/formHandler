<?php

namespace ch\metanet\formHandler\renderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class FieldRenderer {
	protected $attributes = array();
	protected $lockedAttributes = array('value', 'name', 'id', 'aria-required');

	/**
	 * Adds an attribute and its value
	 * @param string $attributeName The attributes value
	 * @param string $value The attributes value
	 */
	public function addAttribute($attributeName, $value)
	{
		if(in_array($attributeName, $this->lockedAttributes) === true)
			return;
		
		$this->attributes[$attributeName] = $value;
	}

	/**
	 * Adds multiple attributes and overwrites existing ones
	 * @param array $attributes The attributes as key and their value as array value
	 */
	public function addAttributes(array $attributes)
	{
		foreach($attributes as $attrName => $attrValue) {
			$this->addAttribute($attrName, $attrValue);
		}
	}

	/**
	 * Removes an attribute from the attribute list
	 * @param string $attributeName The attributes name to remove
	 */
	public function removeAttribute($attributeName)
	{
		if(array_key_exists($attributeName, $this->attributes) === false || in_array($attributeName, $this->lockedAttributes) === true)
			return;
		
		unset($this->attributes[$attributeName]);
	}

	/**
	 * Sets attributes which will be locked and therefor can't be changed
	 * @param array $lockedAttributes The attribute names to lock
	 */
	protected function addLockedAttributes(array $lockedAttributes)
	{
		$this->lockedAttributes = array_merge($this->lockedAttributes, $lockedAttributes);
	}

	/**
	 * Returns a string with all attributes and their values in a valid HTML representation
	 * @return string The attributes in HTML representation
	 */
	protected function getAttributesAsHtml() {
		$htmlAttrs = '';
		
		foreach($this->attributes as $attrName => $attrValue) {
			$htmlAttrs .= ' ' . $attrName . (($attrValue === null || strlen($attrValue) === 0)?null:'="' . $attrValue . '"');
		}
		
		return $htmlAttrs;
	}
}

/* EOF */ 