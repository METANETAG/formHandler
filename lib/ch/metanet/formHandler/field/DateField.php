<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\renderer\DateFieldRenderer;
use ch\metanet\formHandler\renderer\SelectDateFieldRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class DateField extends Field {
	/** @var  DateFieldRenderer */
	protected $dateFieldRenderer;
	protected $allowedDateFormats;

	protected $errorMessageInvalidDate;
	protected $errorMessageNoYear;
	protected $errorMessageInvalidYear;

	public function __construct($name, $label, array $ruleSet = array()) {
		parent::__construct($name, $label, $ruleSet);

		$this->errorMessageInvalidDate = 'The date you entered is invalid';
		$this->errorMessageInvalidDay = 'Please enter a valid day';
		$this->errorMessageInvalidMonth = 'Please enter a valid month';
		$this->errorMessageInvalidYear = 'Please enter a valid year';

		$this->allowedDateFormats = array(
			'Y-m-d', 'y-m-d', 'd.m.Y', 'd.m.y', 'm/d/Y', 'm/d/y'
		);

		$this->dateFieldRenderer = new SelectDateFieldRenderer();
	}

	public function render() {
		return $this->fieldComponentRenderer->render(
			$this,
			'<div class="form-date">' . $this->dateFieldRenderer->render($this) . '</div>'
		);
	}

	public function validate() {
		if($this->isValueEmpty() === false) {
			if($this->validateDate() === false)
				return false;
		}

		return parent::validate();
	}

	public function isValueEmpty() {
		if(parent::isValueEmpty() === true)
			return true;

		if(is_array($this->value) === true) {
			return (
				(isset($this->value['day']) !== false && mb_strlen($this->value['day']) > 0 && $this->value['day'] !== '--') ||
				(isset($this->value['month']) !== false && mb_strlen($this->value['month'] && $this->value['month'] !== '--') > 0) ||
				(isset($this->value['year']) !== false && mb_strlen($this->value['year'] && $this->value['year'] !== '----') > 0)
			);
		}

		return false;
	}


	protected function validateDate() {
		$dateValue = $this->value;

		if(is_array($this->value) === true) {
			if(isset($this->value['day']) === false || preg_match('/^\\d{1,2}$/', $this->value['day']) === 0) {
				$this->errors[] = $this->errorMessageInvalidDay;
			}

			if(isset($this->value['month']) === false || preg_match('/^\\d{1,2}$/', $this->value['month']) === 0) {
				$this->errors[] = $this->errorMessageInvalidMonth;
			}

			if(isset($this->value['year']) === false || preg_match('/^\\d{2,}$/', $this->value['year']) === 0) {
				$this->errors[] = $this->errorMessageInvalidYear;
			}

			if($this->hasErrors() === true)
				return false;

			$dateValue = $this->value['year'] . '-' . $this->value['month'] . '-' . $this->value['day'];
			$this->allowedDateFormats = array('Y-m-d', 'y-m-d');
		}

		$dtObj = $this->createDateFromFormat($dateValue);

		if($dtObj === false) {
			$this->errors[] = $this->errorMessageInvalidDate;
			return false;
		}

		return true;
	}

	protected function createDateFromFormat($dateString) {
		foreach($this->allowedDateFormats as $df) {
			if(($dt = \DateTime::createFromFormat($df, $dateString)) !== false)
				return $dt;
		}

		return false;
	}

	/**
	 * @param DateFieldRenderer $fieldRenderer
	 */
	public function setDateFieldRenderer(DateFieldRenderer $fieldRenderer) {
		$this->dateFieldRenderer = $fieldRenderer;
	}

	/**
	 * @param string $errorMessageInvalidDate
	 */
	public function setErrorMessageInvalidDate($errorMessageInvalidDate) {
		$this->errorMessageInvalidDate = $errorMessageInvalidDate;
	}

	/**
	 * @param array $allowedDateFormats
	 */
	public function setAllowedDateFormats($allowedDateFormats) {
		$this->allowedDateFormats = $allowedDateFormats;
	}

	/**
	 * @return array An array with the allowed date patterns
	 */
	public function getAllowedDateFormats() {
		return $this->allowedDateFormats;
	}
}

/* EOF */