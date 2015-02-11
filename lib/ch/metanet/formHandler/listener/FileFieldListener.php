<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\component\Form;
use ch\metanet\formHandler\field\FileField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class FileFieldListener extends FormFieldListener
{
	/**
	 * @param Form $formHandler
	 * @param FileField $field
	 */
	public function onUploadSuccess(Form $formHandler, FileField $field)
	{

	}

	/**
	 * @param Form $formHandler
	 * @param FileField $file
	 */
	public function onUploadFail(Form $formHandler, FileField $file)
	{

	}
}

/* EOF */