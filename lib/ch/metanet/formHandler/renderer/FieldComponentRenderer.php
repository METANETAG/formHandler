<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\Field;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class FieldComponentRenderer extends ComponentRenderer {
	/**
	 * @param Field $field
	 * @param $renderedField
	 * @return string
	 */
	public abstract function render(Field $field, $renderedField);
}

/* EOF */ 