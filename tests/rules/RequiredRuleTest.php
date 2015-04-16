<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\MinLengthRule;
use ch\metanet\formHandler\rule\RequiredRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class RequiredRuleTest extends \PHPUnit_Framework_TestCase
{
	public function testRequiredRuleSingleValue()
	{
		$rule = new RequiredRule('this field is required');
		$field = new InputField('test', 'test');

		$field->setValue('abc');
		$this->assertSame($rule->validate($field), true, 'Not empty');

		$field->setValue('');
		$this->assertSame($rule->validate($field), false, 'Empty string');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), false, 'Empty (null)');
	}

	public function testRequiredRuleMultipleValue()
	{
		$rule = new RequiredRule('this field is required');
		$field = new OptionsField('test', 'test', array(1 => 'apple', 2 => 'pear', 3 => 'cherry'));

		$field->setValue(array());
		$this->assertSame($rule->validate($field), false, 'Empty array');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), false, 'Empty (null)');
	}
}

/* EOF */