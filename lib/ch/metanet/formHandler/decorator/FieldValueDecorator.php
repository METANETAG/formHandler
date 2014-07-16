<?php

namespace ch\metanet\formHandler\decorator;

use ch\metanet\formHandler\field\FormField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class FieldValueDecorator {
	public abstract function decorate(FormField $field);
}

/* EOF */