<?php


namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\FormFieldListener;
use ch\metanet\formHandler\listener\FileFieldListener;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FileField extends FormField {

	public function render() {
		return '<input type="file" name="' . $this->name . '" id="' . $this->name . '">';
	}

	public function validate() {
		$valid = parent::validate();

		if($valid === false)
			return false;

		$resCode = $this->value['error'];

		foreach($this->listeners as $l) {
			if($l instanceof FileFieldListener === false)
				continue;

			/** @var FileFieldListener $l */
			if($resCode === UPLOAD_ERR_OK) {
				$l->onUploadSuccess($this->formHandler, $this);
			} else {
				$l->onUploadFail($this->formHandler, $this);
			}
		}

		return true;
	}
}

/* EOF */