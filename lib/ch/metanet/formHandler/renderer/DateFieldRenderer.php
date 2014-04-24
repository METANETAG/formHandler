<?php


namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\DateField;


/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class DateFieldRenderer extends FieldRenderer {
	/**
	 * @param DateField $field The field instance to render
	 * @return string The rendered field
	 */
	public abstract function render(DateField $field);
}

/* EOF */ 