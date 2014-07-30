<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\component\Component;
use ch\metanet\formHandler\component\Form;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class DefaultFormComponentRenderer extends FormComponentRenderer {
	protected $submitLabel = 'send';
		
	/**
	 * @param Form $form
	 * @return string
	 */
	public function render(Form $form)
	{
		$formHtml = '<form action="?send" method="' . $form->getMethod() . '">';

		foreach($form->getComponents() as $component) {
			/** @var Component $component */
			$formHtml .= $component->render();
		}

		$formHtml .= '
			<div class="submit">
				<input type="submit" value="' . $this->submitLabel . '">
			</div>
		</form>';

		return $formHtml;
	}

	/**
	 * Set the label for the submit button
	 * @param string $submitLabel Submit buttons label
	 */
	public function setSubmitLabel($submitLabel)
	{
		$this->submitLabel = $submitLabel;
	}
}

/* EOF */ 