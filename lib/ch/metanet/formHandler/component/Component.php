<?php

namespace ch\metanet\formHandler\component;

use ch\metanet\formHandler\listener\FormFieldListener;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class Component
{
	/** @var Form */
	protected $formComponent;
	/** @var Component */
	protected $parentComponent;
	protected $name;
	protected $inputData;
	protected $index;

	// Callbacks
	protected $listeners;
	
	public function __construct($name)
	{
		$this->name = $name;
		$this->listeners = array();
		$this->errors = array();
		$this->index = null;
	}

	/**
	 * Renders the component
	 * 
	 * @return string
	 */
	public abstract function render();

	/**
	 * Validates the component
	 * 
	 * @return bool
	 */
	public abstract function validate();

	/**
	 * Checks if the components value is empty
	 * 
	 * @return bool
	 */
	public abstract function isValueEmpty();

	/**
	 * @return bool
	 */
	public abstract function hasErrors();

	/**
	 * @return array
	 */
	public abstract function getErrors();
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return Component
	 */
	public function getParentComponent()
	{
		return $this->parentComponent;
	}

	/**
	 * @param Component $parentComponent
	 */
	public function setParentComponent(Component $parentComponent)
	{
		$this->parentComponent = $parentComponent;
	}

	/**
	 * @param Form $formComponent
	 */
	public function setFormComponent(Form $formComponent)
	{
		$this->formComponent = $formComponent;
	}

	/**
	 * @return array
	 */
	public function getListeners()
	{
		return $this->listeners;
	}

	/**
	 * @param FormFieldListener $listener
	 */
	public function addListener(FormFieldListener $listener)
	{
		$this->listeners[] = $listener;
	}
	
	public function getFormIdentifierAsString()
	{
		$multiBraces = ($this->index !== null) ? '[' . $this->index . ']' : null;
		
		if($this->parentComponent === null || $this->parentComponent instanceof Form)
			return $this->getName() . $multiBraces;
		
		return $this->parentComponent->getFormIdentifierAsString() . '[' . $this->getName() . ']' . $multiBraces;
	}

	/**
	 * Sets the input data to fill and validate the connected form fields against
	 * @param mixed $data The input data (e.x. $_GET, $_POST, $_FILES or a merged array)
	 */
	public abstract function setRequestData($data);

	/**
	 * @return array
	 */
	public function getRequestData()
	{
		return $this->inputData;
	}

	/**
	 * @param int $index
	 */
	public function setIndex($index)
	{
		$this->index = $index;
	}

	/**
	 * @return int|null
	 */
	public function getIndex()
	{
		return $this->index;
	}
}

/* EOF */