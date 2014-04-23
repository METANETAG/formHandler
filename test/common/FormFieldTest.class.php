<?php

namespace test\common;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class FormFieldTest extends \PHPUnit2_Framework_TestCase {
	public function testSetValue() {
		$field = new InputField('field1', 'field1');

		$field->setValue('test');
		$this->assertEquals($field->getValue(), 'test');

		$field->setValue(null);
		$this->assertNull($field->getValue());
	}

	public function testIsValueEmpty() {
		$field = new InputField('field1', 'field1');
		$fieldOpts = new OptionsField('field1', 'field1', array(1 => 'apple', 2 => 'pear'));

		$this->assertEquals($field->isValueEmpty(), true, 'Null value');
		$this->assertEquals($fieldOpts->isValueEmpty(), true, 'Null value');

		$field->setValue('');
		$this->assertEquals($field->isValueEmpty(), true, 'Empty string');
		$fieldOpts->setValue(array());
		$this->assertEquals($field->isValueEmpty(), true, 'Empty array');

		$field->setValue('test');
		$this->assertEquals($field->isValueEmpty(), false, 'Non-empty string');
		$fieldOpts->setValue(array(1 => 'test'));
		$this->assertEquals($field->isValueEmpty(), false, 'Non-empty array');
	}
}

/* EOF */ 