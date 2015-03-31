<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\DateField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class SelectDateFieldRenderer extends DateFieldRenderer
{
	const LOCALIZED_MONTH_FULL = '%B';
	const LOCALIZED_MONTH_SHORT = '%b';

	protected $yearMin;
	protected $yearMax;
	protected $localizedMonth;

	public function __construct($yearMin = null, $yearMax = null)
	{
		$this->yearMax = $yearMax;
		$this->yearMin = $yearMin;
		$this->localizedMonth = false;
	}

	/**
	 * @param DateField $field The field instance to render
	 * @return string The rendered field
	 */
	public function render(DateField $field)
	{
		$field->setLinkedLabel(false);

		if(is_array($field->getValue()) === false) {
			$field->setValue(array('day' => null, 'month' => null, 'year' => null));
		}

		return $this->renderDay($field) . $this->renderMonth($field) . $this->renderYear($field);
	}

	public function renderDay(DateField $field)
	{
		$fieldValue = $field->getValue();
		$dayOptions = '';

		for($i = 1; $i <= 31; ++$i) {
			$selected = ($i == $fieldValue['day'])?' selected':null;
			$dayOptions .= '<option' . $selected . '>' . $i . '</option>';
		}

		return '<select name="' . $field->getFormIdentifierAsString() . '[day]" class="form-date-day"><option value="">--</option>' . $dayOptions . '</select>';
	}

	public function renderMonth(DateField $field)
	{
		$fieldValue = $field->getValue();
		$monthOptions = '';

		for($i = 1; $i <= 12; ++$i) {
			$label = ($this->localizedMonth !== false) ? strftime($this->localizedMonth, strtotime('2014-' . $i . '-01')) : $i;
			$selected = ($i == $fieldValue['month'])?' selected':null;
			$monthOptions .= '<option value="' . $i . '"' . $selected . '>' . $label . '</option>';
		}

		return '<select name="' . $field->getFormIdentifierAsString() . '[month]" class="form-date-month"><option value="">--</option>' . $monthOptions . '</select>';
	}

	public function renderYear(DateField $field)
	{
		$fieldValue = $field->getValue();

		if(preg_match('/^\\d{2,}$/', $this->yearMin) > 0 && preg_match('/^\\d{2,}$/', $this->yearMax) > 0) {
			$yearHtml = '<select name="' . $field->getFormIdentifierAsString() . '[year]">
				<option value="">----</option>';

			for($i = $this->yearMin; $i <= $this->yearMax; ++$i) {
				$selected = ($i == $fieldValue['year'])?' selected':null;
				$yearHtml .= '<option' . $selected . '>' . $i . '</option>';
			}

			$yearHtml .= '</select>';
		} else {
			$yearHtml = '<input type="text" size="4" name="' . $field->getFormIdentifierAsString() . '[year]" value="' . $fieldValue['year'] . '" class="form-date-year">';
		}

		return $yearHtml;
	}

	/**
	 * @param mixed $localizedMonth
	 */
	public function setLocalizedMonth($localizedMonth)
	{
		$this->localizedMonth = $localizedMonth;
	}
}

/* EOF */