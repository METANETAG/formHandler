<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\renderer\TimeFieldRenderer;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class DateTimeField extends DateField
{
	const TIME_WITH_SECONDS = 'H:i:s';
	const TIME_WITHOUT_SECONDS = 'H:i';

	protected $timeFormat;
	/** @var  TimeFieldRenderer */
	protected $timeFieldRenderer;

	protected $errorMessageInvalidHour;
	protected $errorMessageInvalidMinute;
	protected $errorMessageInvalidSecond;

	public function __construct($name, $label, $timeFormat = self::TIME_WITH_SECONDS, array $ruleSet = array())
	{
		parent::__construct($name, $label, $ruleSet);

		$this->timeFormat = $timeFormat;

		$this->errorMessageInvalidHour = 'Please choose a valid hour';
		$this->errorMessageInvalidMinute = 'Please choose a valid minute';
		$this->errorMessageInvalidSecond = 'Please choose a valid second';
		$this->errorMessageInvalidDate = 'The date and time you entered is invalid';

		$this->allowedDateFormats = array(
			'Y-m-d ' . $timeFormat,
			'y-m-d ' . $timeFormat,
			'd.m.Y ' . $timeFormat,
			'd.m.y ' . $timeFormat,
			'm/d/Y ' . $timeFormat,
			'm/d/y ' . $timeFormat
		);
	}

	public function render()
	{
		return $this->fieldComponentRenderer->render(
			$this,
			'<div class="form-date">' . $this->dateFieldRenderer->render($this) . (($this->timeFieldRenderer !== null)?$this->timeFieldRenderer->render($this):null) . '</div>'
		);
	}

	public function isValueEmpty()
	{
		if(parent::isValueEmpty() === true)
			return true;

		if(is_array($this->value) === true) {
			return !(
				(isset($this->value['hour']) !== false && mb_strlen($this->value['hour']) > 0) ||
				(isset($this->value['min']) !== false && mb_strlen($this->value['min']) > 0) ||
				(isset($this->value['sec']) !== false && mb_strlen($this->value['sec']) > 0)
			);
		}

		return false;
	}

	protected function validateDate()
	{
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

			// Time
			if(isset($this->value['hour']) === false || preg_match('/^\\d{1,2}$/', $this->value['hour']) === 0) {
				$this->errors[] = $this->errorMessageInvalidHour;
			}

			if(isset($this->value['min']) === false || preg_match('/^\\d{1,2}$/', $this->value['min']) === 0) {
				$this->errors[] = $this->errorMessageInvalidMinute;
			}

			if($this->timeFormat === self::TIME_WITH_SECONDS) {
				if(isset($this->value['sec']) === false || preg_match('/^\\d{1,2}$/', $this->value['sec']) === 0) {
					$this->errors[] = $this->errorMessageInvalidSecond;
				}
			}

			if($this->hasErrors() === true)
				return false;

			$dateValue = $this->value['year'] . '-' . $this->value['month'] . '-' . $this->value['day'] . ' ' . $this->value['hour'] . ':' . $this->value['min'] . ':' . $this->value['sec'];
			$this->allowedDateFormats = array('Y-m-d H:i:s', 'y-m-d H:i:s');
		}

		$dtObj = $this->createDateFromFormat($dateValue);

		if($dtObj === false) {
			$this->errors[] = $this->errorMessageInvalidDate;
			return false;
		}

		return true;
	}

	/**
	 * @param mixed $timeFieldRenderer
	 */
	public function setTimeFieldRenderer(TimeFieldRenderer $timeFieldRenderer)
	{
		$this->timeFieldRenderer = $timeFieldRenderer;
	}

	/**
	 * @param string $timeFormat
	 */
	public function setTimeFormat($timeFormat)
	{
		$this->timeFormat = $timeFormat;
	}

	/**
	 * @return string
	 */
	public function getTimeFormat()
	{
		return $this->timeFormat;
	}

	/**
	 * @param string $errorMessageInvalidHour
	 */
	public function setErrorMessageInvalidHour($errorMessageInvalidHour)
	{
		$this->errorMessageInvalidHour = $errorMessageInvalidHour;
	}

	/**
	 * @param string $errorMessageInvalidMinute
	 */
	public function setErrorMessageInvalidMinute($errorMessageInvalidMinute)
	{
		$this->errorMessageInvalidMinute = $errorMessageInvalidMinute;
	}

	/**
	 * @param string $errorMessageInvalidSecond
	 */
	public function setErrorMessageInvalidSecond($errorMessageInvalidSecond)
	{
		$this->errorMessageInvalidSecond = $errorMessageInvalidSecond;
	}
}

/* EOF */