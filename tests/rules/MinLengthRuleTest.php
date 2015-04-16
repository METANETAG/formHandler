<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\MinLengthRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class MinLengthRuleTest extends \PHPUnit_Framework_TestCase
{
	public function testMinLengthRuleSingleValue()
	{
		$rule = new MinLengthRule(2, 'too short');
		$field = new InputField('test', 'test');
		$field->setValue('abc');

		$this->assertSame($rule->validate($field), true, 'Long enough');

		$field->setValue('ab');
		$this->assertSame($rule->validate($field), true, 'On boundaries');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'Zero length');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), true, 'Zero length');
	}

	public function testMinLengthRuleMultipleValues()
	{
		$rule = new MinLengthRule(2, 'too short');
		$field = new OptionsField('test', 'test', array(1 => 'apple', 2 => 'pear', 3 => 'cherry'));

		$field->setValue(array());
		$this->assertSame($rule->validate($field), true, 'Empty array');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), true, 'Empty (null)');

		$field->setValue(array(1 => 'apple'));
		$this->assertSame($rule->validate($field), false, 'Too short (1 entry)');

		$field->setValue(array(1 => 'apple', 2 => 'pear'));
		$this->assertSame($rule->validate($field), true, 'Okay (2 entries)');
	}
}

/* EOF */