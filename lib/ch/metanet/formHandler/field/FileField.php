<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\listener\FileFieldListener;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FileField extends Field {
	const VALUE_NAME = 'name';
	const VALUE_TMP_NAME = 'tmp_name';
	const VALUE_TYPE = 'type';
	const VALUE_ERROR = 'error';
	const VALUE_SIZE = 'size';

	public function render() {
		return $this->fieldComponentRenderer->render(
			$this,
			'<input type="file" name="' . $this->name . '" id="' . $this->name . '">'
		);
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

	public function isValueEmpty() {
		if(parent::isValueEmpty() === true)
			return true;

		if($this->value[self::VALUE_ERROR] === UPLOAD_ERR_NO_FILE)
			return true;

		return false;
	}


	/**
	 * @param string|null $selector The data selector. NULL means the whole data array
	 * @return string|array|null The selected field data
	 */
	public function getValue($selector = null) {
		if($selector === null)
			return $this->value;

		return $this->value[$selector];
	}
}

/* EOF */