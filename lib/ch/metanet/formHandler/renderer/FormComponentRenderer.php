<?php


namespace ch\metanet\formHandler\renderer;
use ch\metanet\formHandler\field\FormField;


/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
abstract class FormComponentRenderer {
	public abstract function render(FormField $field);
}

/* EOF */ 