<?php

namespace ch\metanet\formHandler\component;

use ch\metanet\formHandler\field\Field;
use ch\metanet\formHandler\renderer\DefaultFormComponentRenderer;
use ch\metanet\formHandler\renderer\FormComponentRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class Form extends Collection {
	const METHOD_POST = 'post';
	const METHOD_GET = 'get';

	protected $method;
	protected $action;
	
	protected $sentVar;

	/** @var FormComponentRenderer */
	protected $collectionComponentRenderer;

	/**
	 * @param string $method
	 * @param string $sentVar The name of the variable to recognize that the form has been sent to the server
	 */
	public function __construct($method = self::METHOD_POST, $sentVar = 'send') {
		$this->components = array();

		$this->method = $method;
		$this->sentVar = $sentVar;
		$this->inputData = array();
		$this->errors = array();
		
		$this->formComponent = $this;
		$this->collectionComponentRenderer = new DefaultFormComponentRenderer();
	}

	/**
	 * Renders the whole form including submit button, all form components and the form tag itself
	 * @return string The HTML code for this form
	 */
	public function render() {
		return $this->collectionComponentRenderer->render($this);
	}

	/**
	 * Checks if the form has been sent to the server
	 * @return bool
	 */
	public function isSent() {
		return array_key_exists($this->sentVar, $this->inputData);
	}

	/**
	 * Returns a key value map of all connected fields. Where the field name is the key and its current data the value.
	 * @return array A key value map of all the fields connected to this form handler instance
	 */
	public function getFieldsAsKeyValueMap() {
		return $this->getFieldsAsKeyValueMapRecursive($this->components);
	}
	
	protected function getFieldsAsKeyValueMapRecursive(array $components) {
		$keyValueMap = array();
		
		foreach($components as $name => $component) {
			if($component instanceof Collection)
				$keyValueMap[$name] = $this->getFieldsAsKeyValueMapRecursive($component->getComponents());
			elseif($component instanceof Field) {
				$keyValueMap[$component->getName()] = $component->getValue();
			} elseif(is_array($component) === true ) {
				$keyValueMap[$name] = $this->getFieldsAsKeyValueMapRecursive($component);
			}
		}
		
		return $keyValueMap;
	}
	
	public function addField(Field $field) {
		$this->addComponent($field);
	}
	
	public function addFields(array $fields) {
		$this->addComponents($fields);
	}

	/**
	 * @param FormComponentRenderer $formComponentRenderer
	 */
	public function setCollectionComponentRenderer(FormComponentRenderer $formComponentRenderer) {
		$this->collectionComponentRenderer = $formComponentRenderer;
	}

	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	
}

/* EOF */ 