<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class InputFieldRenderer extends FieldRenderer {
	/**
	 * @param InputField $field
	 * @return string
	 */
	public abstract function render(InputField $field);
}

/* EOF */ 