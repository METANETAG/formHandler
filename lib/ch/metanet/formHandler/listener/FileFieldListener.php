<?php

namespace ch\metanet\formHandler\listener;

use ch\metanet\formHandler\field\FileField;
use ch\metanet\formHandler\FormHandler;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FileFieldListener extends FormFieldListener {
	/**
	 * @param FormHandler $formHandler
	 * @param FileField $field
	 */
	public function onUploadSuccess(FormHandler $formHandler, FileField $field) {

	}

	/**
	 * @param FormHandler $formHandler
	 * @param FileField $file
	 */
	public function onUploadFail(FormHandler $formHandler, FileField $file) {

	}
}

/* EOF */