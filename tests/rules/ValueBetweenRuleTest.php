<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\MaxLengthRule;
use ch\metanet\formHandler\rule\ValueBetweenRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class ValueBetweenRuleTest extends \PHPUnit_Framework_TestCase
{
	public function testValueBetweenRuleSingleValueInteger()
	{
		$rule = new ValueBetweenRule(5, 10, 'The value has to be between 5 and 10');
		$field = new InputField('test', 'test');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'Empty string');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), true, 'Empty (null)');

		$field->setValue('abc');
		$this->assertSame($rule->validate($field), false, 'Value abc');

		$field->setValue('4');
		$this->assertSame($rule->validate($field), false, 'Value 0');

		$field->setValue('5');
		$this->assertSame($rule->validate($field), true, 'Value 5');

		$field->setValue('10');
		$this->assertSame($rule->validate($field), true, 'Value 10');

		$field->setValue('11');
		$this->assertSame($rule->validate($field), false, 'Value 11');

		$field->setValue('005');
		$this->assertSame($rule->validate($field), true, 'Value 004');

		$field->setValue('00010');
		$this->assertSame($rule->validate($field), true, 'Value 00010');
	}

	public function testValueBetweenRuleSingleValueString()
	{
		$rule = new ValueBetweenRule('a', 'd', 'The value has to be between "a" and "d"');
		$field = new InputField('test', 'test');

		$field->setValue('9');
		$this->assertSame($rule->validate($field), false, 'Value 9');

		$field->setValue('a');
		$this->assertSame($rule->validate($field), true, 'Value a');

		$field->setValue('d');
		$this->assertSame($rule->validate($field), true, 'Value d');

		$field->setValue('z');
		$this->assertSame($rule->validate($field), false, 'Value z');
	}

	public function testMaxLengthRuleMultipleValues()
	{
		$rule = new ValueBetweenRule(5, 10, 'The value has to be between 5 and 10');
		$field = new OptionsField('test', 'test', array(1 => 'apple', 2 => 'pear', 3 => 'cherry'));

		$field->setValue(array());
		$this->assertSame($rule->validate($field), true, 'Empty array');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), true, 'Empty (null)');

		$field->setValue(array(1, 6, 7));
		$this->assertSame($rule->validate($field), false, '1 out of range, array(1, 6, 7)');

		$field->setValue(array(6, 7, 11));
		$this->assertSame($rule->validate($field), false, '11 out of range, array(6, 7, 11)');

		$field->setValue(array(6, 7, array(3, 12), 8));
		$this->assertSame($rule->validate($field), false, '3 out of range, array(6, 7, array(3, 12), 8)');

		$field->setValue(array(6, 7, array(5, 10), 8));
		$this->assertSame($rule->validate($field), true, 'Okay, array(6, 7, array(5, 10), 8)');
	}
}

/* EOF */