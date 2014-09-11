<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\MaxLengthRule;
use ch\metanet\formHandler\rule\ValidValueRule;
use ch\metanet\formHandler\rule\ValueBetweenRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidValueRuleTest extends \PHPUnit_Framework_TestCase {
	public function testSingeValue()
	{
		$rule = new ValidValueRule('foo', 'This not a valid value');
		$field = new InputField('test', 'test');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'Empty field');

		$field->setValue('bar');
		$this->assertSame($rule->validate($field), false, 'Invalid value');

		$field->setValue('foo');
		$this->assertSame($rule->validate($field), true, 'Valid value');
	}
	
	public function testMultipleValues() {
		$rule = new ValidValueRule(array('foo', 42), 'This not a valid value');
		$field = new InputField('test', 'test');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'Empty field');

		$field->setValue(array());
		$this->assertSame($rule->validate($field), true, 'Empty field');

		$field->setValue('bar');
		$this->assertSame($rule->validate($field), false, 'Invalid value');

		$field->setValue(array('bar', 'foo', 42));
		$this->assertSame($rule->validate($field), false, 'Invalid values');

		$field->setValue('foo');
		$this->assertSame($rule->validate($field), true, 'Valid value');

		$field->setValue(array('foo', 42));
		$this->assertSame($rule->validate($field), true, 'Valid values');
	}
}

/* EOF */