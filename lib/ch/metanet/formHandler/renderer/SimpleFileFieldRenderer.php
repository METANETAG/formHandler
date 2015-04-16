<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\FileField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
class SimpleFileFieldRenderer extends FileFieldRenderer
{
	protected $numberOfFiles;

	/**
	 * @param int $numberOfFiles
	 */
	public function __construct($numberOfFiles = 1)
	{
		$this->numberOfFiles = $numberOfFiles;
	}
	
	/**
	 * @param FileField $field
	 *
	 * @return string
	 */
	public function render(FileField $field)
	{
		$required = null;

		if($field->hasRule('ch\metanet\formHandler\rule\RequiredRule'))
			$required = ' aria-required="true"';
		
		if($this->numberOfFiles <= 1)
			return '<input type="file" name="' . $field->getFormIdentifierAsString() . '" id="' . $field->getId() . '" ' . $this->getAttributesAsHtml() . $required . '>';
		
		$field->setLinkedLabel(false);
		
		$html = '<ul' . $this->getAttributesAsHtml() . '>';
		
		for($i = 0; $i < $this->numberOfFiles; $i++) {
			$html .= '<li><input type="file" name="' . $field->getFormIdentifierAsString() . '[]" id="' . $field->getId() . '-' . $i . '" ' . ($i === 0 ? $required : null) . '></li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}

	/**
	 * @param int $numberOfFiles
	 */
	public function setNumberOfFiles($numberOfFiles)
	{
		$this->numberOfFiles = $numberOfFiles;
	}
}

/* EOF */