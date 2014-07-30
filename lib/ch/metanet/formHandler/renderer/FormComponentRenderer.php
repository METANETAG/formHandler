<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\component\Form;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class FormComponentRenderer extends ComponentRenderer {
	/**
	 * @param Form $form
	 * @return string
	 */
	public abstract function render(Form $form);
}

/* EOF */ 