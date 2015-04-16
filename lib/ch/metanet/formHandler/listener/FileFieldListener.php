<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\component\Form;
use ch\metanet\formHandler\field\FileField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class FileFieldListener extends FormFieldListener
{
	/**
	 * Gets executed if the file was uploaded successfully
	 * 
	 * @param Form $form The parent Form component
	 * @param FileField $field The FileField instance
	 * @param array $fileInfo Information about the uploaded file
	 */
	public function onUploadSuccess(Form $form, FileField $field, array $fileInfo)
	{

	}

	/**
	 * Gets executed if the file upload failed
	 * 
	 * @param Form $form The parent Form component
	 * @param FileField $file The FileField instance
	 * @param array $fileInfo Information about the uploaded file
	 */
	public function onUploadFail(Form $form, FileField $file, array $fileInfo)
	{

	}
}

/* EOF */