<?php

namespace tests\fields;

use ch\metanet\formHandler\field\OptionsField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class OptionsFieldTest extends \PHPUnit_Framework_TestCase {
	public function testSetValue() {
		$field = new OptionsField('field1', 'field1', array());

		$field->setValue(array(1));
		$this->assertEquals($field->getValue(), array(1));

		$field->setValue(null);
		$this->assertNull($field->getValue());
	}

	public function testValidate() {
		$field = new OptionsField('test', 'test', array(1 => 'some value'));

		$field->setValue(2);
		$this->assertSame($field->validate(), false, 'Invalid scalar value');

		$field->setValue(array(2));
		$this->assertSame($field->validate(), false, 'Invalid array value');

		$field->setValue(1);
		$this->assertSame($field->validate(), true, 'Correct scalar value');

		$field->setValue(array(1));
		$this->assertSame($field->validate(), true, 'Correct array value');
	}

	public function testIsValueEmpty() {
		$field = new OptionsField('field1', 'field1', array(1 => 'apple', 2 => 'pear'));

		$this->assertEquals($field->isValueEmpty(), true, 'Null value');

		$field->setValue(array());
		$this->assertEquals($field->isValueEmpty(), true, 'Empty array');

		$field->setValue(array(1));
		$this->assertEquals($field->isValueEmpty(), false, 'Non-empty array');
	}
}

/* EOF */