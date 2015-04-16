<?php

namespace ch\metanet\formHandler\field;

use ch\metanet\formHandler\listener\FileFieldListener;
use ch\metanet\formHandler\renderer\FileFieldRenderer;
use ch\metanet\formHandler\renderer\SimpleFileFieldRenderer;
use timesplinter\tsfw\common\ArrayUtils;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class FileField extends Field
{
	const VALUE_NAME = 'name';
	const VALUE_TMP_NAME = 'tmp_name';
	const VALUE_TYPE = 'type';
	const VALUE_ERROR = 'error';
	const VALUE_SIZE = 'size';

	/** @var FileFieldRenderer */
	protected $fileFieldRenderer;

	public function __construct($name, $label, array $ruleSet = array())
	{
		parent::__construct($name, $label, $ruleSet);

		$this->fileFieldRenderer = new SimpleFileFieldRenderer();
	}


	public function render()
	{
		return $this->fieldComponentRenderer->render($this,	$this->fileFieldRenderer->render($this));
	}

	public function validate()
	{
		if(parent::validate() === false)
			return false;

		foreach($this->listeners as $l) {
			if($l instanceof FileFieldListener === false)
				continue;

			/** @var FileFieldListener $l */

			if(ArrayUtils::isAssociative($this->value) === true) {
				if($this->value[self::VALUE_ERROR] === UPLOAD_ERR_OK) {
					$l->onUploadSuccess($this->formComponent, $this, $this->value);
				} else {
					$l->onUploadFail($this->formComponent, $this, $this->value);
				}
			} else {
				foreach($this->value as $fileInfo) {
					if($fileInfo[self::VALUE_ERROR] === UPLOAD_ERR_OK) {
						$l->onUploadSuccess($this->formComponent, $this, $fileInfo);
					} else {
						$l->onUploadFail($this->formComponent, $this, $fileInfo);
					}
				}
			}
		}

		return true;
	}

	public function isValueEmpty()
	{
		if(parent::isValueEmpty() === true)
			return true;

		// @TODO make it nicer
		if(ArrayUtils::isAssociative($this->value) === true) {
			return (isset($this->value[self::VALUE_ERROR]) === false || $this->value[self::VALUE_ERROR] === UPLOAD_ERR_NO_FILE);
		}

		foreach($this->value as $i => $fileInfo) {
			if($fileInfo[self::VALUE_ERROR] === UPLOAD_ERR_NO_FILE)
				continue;

			return false;
		}

		return true;
	}

	/**
	 * @param string|null $selector The data selector. NULL means the whole data array
	 * @return string|array|null The selected field data
	 */
	public function getValue($selector = null)
	{
		if($selector === null)
			return $this->value;

		return $this->value[$selector];
	}

	public function setInputData($data)
	{
		if($data !== null && is_array($data) === false) {
			throw new \InvalidArgumentException('Illegal input data for field ' . $this->name . '. Input data should be an array but is ' . gettype($data) . '.');
		}

		$normalizedData = (is_array($data[self::VALUE_ERROR]) === false) ? $data : $this->convertMultiFileArray($data);

		parent::setInputData($normalizedData);
	}

	/**
	 * @return FileFieldRenderer
	 */
	public function getFileFieldRenderer()
	{
		return $this->fileFieldRenderer;
	}

	/**
	 * @param FileFieldRenderer $fileFieldRenderer
	 */
	public function setFileFieldRenderer(FileFieldRenderer $fileFieldRenderer)
	{
		$this->fileFieldRenderer = $fileFieldRenderer;
	}

	/**
	 * Restructures an input array of multiple files
	 *
	 * @param array $filesArr
	 *
	 * @return array
	 */
	protected function convertMultiFileArray(array $filesArr)
	{
		$files = array();
		$filesCount = count($filesArr[self::VALUE_NAME]);

		for($i = 0; $i < $filesCount; ++$i) {
			$files[] = array(
				self::VALUE_NAME => $filesArr[self::VALUE_NAME][$i],
				self::VALUE_TYPE => $filesArr[self::VALUE_TYPE][$i],
				self::VALUE_TMP_NAME => $filesArr[self::VALUE_TMP_NAME][$i],
				self::VALUE_ERROR => $filesArr[self::VALUE_ERROR][$i],
				self::VALUE_SIZE => $filesArr[self::VALUE_SIZE][$i],
			);
		}

		return $files;
	}
}

/* EOF */