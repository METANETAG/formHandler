<?php

namespace tests\fields;

use ch\metanet\formHandler\component\Form;
use ch\metanet\formHandler\field\FileField;
use ch\metanet\formHandler\listener\FileFieldListener;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
class FileFieldTest extends \PHPUnit_Framework_TestCase
{
	public function testIsValidFileArray()
	{
		$fileField = new FileField('file', 'File');

		$method = new \ReflectionMethod(
			'ch\metanet\formHandler\field\FileField', 'isValidFileArray'
		);

		$method->setAccessible(true);
		
		$validFileArray = array(
			'name' => '',
			'tmp_name' => '',
			'size' => '',
			'error' => '',
			'type' => ''
		);
		
		$invalidFileArray1 = array(
			'name' => ''
		);
		
		$invalidFileArray2 = array(
			'name', 'tmp_name', 'size', 'error', 'type'
		);
		
		$this->assertEquals(false, $method->invoke($fileField, $invalidFileArray1));
		$this->assertEquals(false, $method->invoke($fileField, $invalidFileArray2));
		$this->assertEquals(true, $method->invoke($fileField, $validFileArray));
	}

	public function testConvertMultiFileArray()
	{
		$fileField = new FileField('file', 'File');

		$method = new \ReflectionMethod(
			'ch\metanet\formHandler\field\FileField', 'convertMultiFileArray'
		);

		$method->setAccessible(true);

		$this->assertEquals($this->getNormalizedFileArray(), $method->invoke($fileField, $this->getRequestFileArray()));
	}
	
	public function testSetValue()
	{
		$field = new FileField('field1', 'field1');

		$field->setValue(null);
		$this->assertNull($field->getValue(), 'Null');
		
		$field->setValue(array());
		$this->assertEquals(array(), $field->getValue(), 'Empty array');

		$this->setExpectedException('\InvalidArgumentException');
		$field->setValue('test');

		$this->setExpectedException('\InvalidArgumentException');
		$field->setValue($this->getRequestFileArray());
		
		$field->setValue($this->getNormalizedFileArray());
		$this->assertEquals($this->getNormalizedFileArray(), $field->getValue());
	}

	public function testIsValueEmpty()
	{
		$field = new FileField('field1', 'field1');
		
		$field->setValue(null);
		$this->assertEquals($field->isValueEmpty(), true, 'Null value');

		$field->setValue(array());
		$this->assertEquals($field->isValueEmpty(), true, 'Empty array');
		
		$field->setValue($this->getNormalizedFileArray());
		$this->assertEquals($field->isValueEmpty(), false);

		$field->setValue($this->getEmptyNormalizedFileArray());
		$this->assertEquals($field->isValueEmpty(), true);
	}
	
	public function testValidation()
	{
		/** @var FileFieldListener $mockFileFieldListener */
		$mockFileFieldListener = $this->getMock(FileFieldListener::class);
		/** @var Form $mockForm */
		$mockForm = $this->getMock(Form::class);

		$field = new FileField('field1', 'field1');
		$field->setFormComponent($mockForm);
		$field->addListener($mockFileFieldListener);
		
		$this->assertTrue($field->validate());
	}
	
	protected function getRequestFileArray()
	{
		return array(
			'name' => array(
				0 => 'file1.txt',
				1 => 'file2.txt'
			),

			'tmp_name' => array(
				0 => '/tmp/phpFOO',
				1 => '/tmp/phpBAR'
			),

			'size' => array(
				0 => 36,
				1 => 50
			),

			'error' => array(
				0 => 0,
				1 => 0
			),

			'type' => array(
				0 => 'text/plain',
				1 => 'text/plain'
			)
		);
	}
	
	protected function getNormalizedFileArray()
	{
		return array(
			0 => array(
				'name' => 'file1.txt',
				'tmp_name' => '/tmp/phpFOO',
				'size' => 36,
				'error' => 0,
				'type' => 'text/plain'
			),

			1 => array(
				'name' => 'file2.txt',
				'tmp_name' => '/tmp/phpBAR',
				'size' => 50,
				'error' => 0,
				'type' => 'text/plain'
			)
		);
	}
	
	protected function getEmptyNormalizedFileArray()
	{
		$array = $this->getNormalizedFileArray();
		
		$array[0]['error'] = UPLOAD_ERR_NO_FILE;
		$array[1]['error'] = UPLOAD_ERR_NO_FILE;
		
		return $array;
	}
}

/* EOF */