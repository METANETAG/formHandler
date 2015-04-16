<?php

namespace tests\fields;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class InputFieldTest extends \PHPUnit_Framework_TestCase
{
	public function testSetValue()
	{
		$field = new InputField('field1', 'field1');

		$field->setValue('test');
		$this->assertEquals($field->getValue(), 'test');

		$field->setValue(null);
		$this->assertNull($field->getValue());
	}

	public function testIsValueEmpty()
	{
		$field = new InputField('field1', 'field1');

		$this->assertEquals($field->isValueEmpty(), true, 'Null value');

		$field->setValue('');
		$this->assertEquals($field->isValueEmpty(), true, 'Empty string');

		$field->setValue('test');
		$this->assertEquals($field->isValueEmpty(), false, 'Non-empty string');
	}
}

/* EOF */ 