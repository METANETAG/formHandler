<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\field\FileField;
use ch\metanet\formHandler\FormComponent;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FileFieldListener extends FormFieldListener {
	/**
	 * @param FormComponent $formHandler
	 * @param FileField $field
	 */
	public function onUploadSuccess(FormComponent $formHandler, FileField $field) {

	}

	/**
	 * @param FormComponent $formHandler
	 * @param FileField $file
	 */
	public function onUploadFail(FormComponent $formHandler, FileField $file) {

	}
}

/* EOF */