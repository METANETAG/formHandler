<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\FileField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
abstract class FileFieldRenderer extends FieldRenderer
{
	/**
	 * @param FileField $field
	 * @return string
	 */
	public abstract function render(FileField $field);
}

/* EOF */