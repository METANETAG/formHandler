<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\DateTimeField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class SelectTimeFieldRenderer extends TimeFieldRenderer
{
	protected $minutesStep;
	protected $secondsStep;

	public function __construct($minutesStep = 1, $secondsStep = 1)
	{
		$this->minutesStep = $minutesStep;
		$this->secondsStep = $secondsStep;
	}

	/**
	 * @param DateTimeField $field
	 * @return string
	 */
	public function render(DateTimeField $field)
	{
		$field->setLinkedLabel(false);

		if(is_array($field->getValue()) === false) {
			$field->setValue(array('day' => null, 'month' => null, 'year' => null, 'hour' => null, 'min' => null, 'sec' => null));
		} else {
			$field->setValue(array('day' => null, 'month' => null, 'year' => null, 'hour' => null, 'min' => null, 'sec' => null) + $field->getValue());
		}

		$timeHtml = $this->renderHour($field) . $this->renderMin($field);

		if($field->getTimeFormat() === DateTimeField::TIME_WITH_SECONDS) {
			$timeHtml .= $this->renderSec($field);
		}

		return $timeHtml;
	}

	public function renderHour(DateTimeField $field)
	{
		$fieldValue = $field->getValue();

		$hourHtml = '<select name="' . $field->getName() . '[hour]" id="' . $field->getName() . '-hour" class="form-date-hour">
			<option>--</option>';

		for($i = 0; $i <= 23; ++$i) {
			$selected = (is_numeric($fieldValue['hour'])  && $i == $fieldValue['hour'])?' selected':null;
			$hourHtml .= '<option' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}

		$hourHtml .= '</select>';

		return $hourHtml;
	}

	public function renderMin(DateTimeField $field)
	{
		$fieldValue = $field->getValue();

		$hourHtml = '<select name="' . $field->getName() . '[min]" id="' . $field->getName() . '-min" class="form-date-min">
			<option>--</option>';

		for($i = 0; $i <= 59; $i = $i+$this->minutesStep) {
			$selected = (is_numeric($fieldValue['min']) && $i == $fieldValue['min'])?' selected':null;
			$hourHtml .= '<option' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}

		$hourHtml .= '</select>';

		return $hourHtml;
	}

	public function renderSec(DateTimeField $field)
	{
		$fieldValue = $field->getValue();

		$hourHtml = '<select name="' . $field->getName() . '[sec]" id="' . $field->getName() . '-hour" class="form-date-sec">
			<option>--</option>';

		for($i = 0; $i <= 59; $i = $i+$this->secondsStep) {
			$selected = (is_numeric($fieldValue['sec'])  && $i == $fieldValue['sec'])?' selected':null;
			$hourHtml .= '<option' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}

		$hourHtml .= '</select>';

		return $hourHtml;
	}
}

/* EOF */