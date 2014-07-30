<?php

namespace ch\metanet\formHandler\component;

use ch\metanet\formHandler\field\Field;
use ch\metanet\formHandler\listener\FormFieldListener;
use ch\metanet\formHandler\renderer\CollectionComponentRenderer;
use ch\metanet\formHandler\renderer\DefaultCollectionComponentRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class Collection extends Component {
	protected $components;
	
	/** @var CollectionComponentRenderer */
	protected $collectionComponentRenderer;

	public function __construct($name)
	{
		parent::__construct($name);
		
		$this->collectionComponentRenderer = new DefaultCollectionComponentRenderer();
		$this->inputData = array();
		$this->components = array();
	}
	
	/**
	 * Connects an undefined amount of form fields with this form handler instance preserving the already connected
	 * fields of this instance
	 * @param array $components The array with form fields to be connected
	 */
	public function addComponents(array $components)
	{
		foreach($components as $fld)
			$this->addComponent($fld);
	}

	/**
	 * Connects an undefined amount of form fields with this form handler instance and overrides all the already
	 * connected fields of this instance
	 * @param array $components The array with form fields to be connected
	 */
	public function setComponents(array $components)
	{
		$this->components = array();
		$this->addComponents($components);
	}

	/**
	 * Connects a field with the form handler instance
	 * @param Component $component The form field to add
	 */
	public function addComponent(Component $component)
	{
		$component->setParentComponent($this);
		$component->setFormComponent($this->formComponent);

		// Single field
		$this->components[$component->getName()] = $component;

		// Set value if there is one
		if(array_key_exists($component->getName(), $this->inputData) === true)
			$component->setInputData($this->inputData[$component->getName()]);
		else
			$component->setInputData(null);
	}

	/**
	 * Returns all connected fields for this form handler instance
	 * @return array All connected fields of this form handler instance
	 */
	public function getComponents()
	{
		return $this->components;
	}

	/**
	 * Returns a connected component of this form handler instance selected by its name
	 * @param string $name The name of the component
	 * @throws \OutOfBoundsException If the field does not exist
	 * @return Component The component
	 */
	public function getComponent($name) {
		if(isset($this->components[$name]) === false)
			throw new \OutOfBoundsException('The field with name "' . $name . '" does not exist');

		return $this->components[$name];
	}
	
	public function render()
	{
		return $this->collectionComponentRenderer->render($this);
	}

	/**
	 * @param CollectionComponentRenderer $collectionComponentRenderer
	 */
	public function setCollectionComponentRenderer(CollectionComponentRenderer $collectionComponentRenderer)
	{
		$this->collectionComponentRenderer = $collectionComponentRenderer;
	}

	public function validate()
	{
		$validation = true;
		
		foreach($this->components as $component) {
			/** @var Component $component */
			if($component->validate() === false) {
				$validation = false;
				$this->errors = array_merge($this->errors, $component->getErrors());
			}

			$this->invokeListeners($component);
		}
		
		return $validation;
	}
	
	protected function invokeListeners(Component $component) {
		$isValueEmpty = $component->isValueEmpty();
		
		foreach($component->getListeners() as $l) {
			/** @var FormFieldListener $l */
			if($isValueEmpty === true) {
				$l->onEmptyValueAfterValidation($this->formComponent, $component);
			} else {
				$l->onNotEmptyValueAfterValidation($this->formComponent, $component);
			}
		}
	}

	public function isValueEmpty()
	{
		$validation = true;

		foreach($this->components as $component) {
			/** @var Component $component */
			if($component->isValueEmpty() === false)
				$validation = false;
		}

		return $validation;
	}

	public function setInputData($data)
	{
		if($data === null)
			$data = array();
		elseif(is_scalar($data) === true)
			$data = array($data);
		
		parent::setInputData($data);
		
		// Delegate values
		foreach($this->components as $component) {
			/** @var Component $component */
			if(array_key_exists($component->getName(), $data) === false)
				continue;
			
			$component->setInputData($data[$component->getName()]);
		}
	}

	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		foreach($this->components as $component) {
			/** @var Component $component */
			if($component->hasErrors() === true)
				return true;
		}
		
		return false;
	}

	/**
	 * @return array
	 */
	public function getErrors()
	{
		$errors = array();

		foreach($this->components as $component) {
			/** @var Component $component */
			$errors = array_merge($errors, $component->getErrors());
		}
		
		return $errors;
	}
}

/* EOF */ 