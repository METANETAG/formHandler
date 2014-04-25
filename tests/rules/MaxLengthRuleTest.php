<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\MaxLengthRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class MaxLengthRuleTest extends \PHPUnit_Framework_TestCase {
	public function testMaxLengthRuleSingeValue() {
		$rule = new MaxLengthRule(2, 'too long');
		$field = new InputField('test', 'test');
		$field->setValue('abc');

		$this->assertSame($rule->validate($field), false);

		$field->setValue('ab');
		$this->assertSame($rule->validate($field), true);

		$field->setValue('');
		$this->assertSame($rule->validate($field), true);
	}

	public function testMaxLengthRuleMultipleValues() {
		$rule = new MaxLengthRule(2, 'too long');
		$field = new OptionsField('test', 'test', array(1 => 'apple', 2 => 'pear', 3 => 'cherry'));

		$field->setValue(array());
		$this->assertSame($rule->validate($field), true, 'Empty array');

		$field->setValue(null);
		$this->assertSame($rule->validate($field), true, 'Empty (null)');

		$field->setValue(array(1 => 'apple', 2 => 'pear'));
		$this->assertSame($rule->validate($field), true, 'Okay (2 entries)');

		$field->setValue(array(1 => 'apple', 2 => 'pear', 3 => 'cherry'));
		$this->assertSame($rule->validate($field), false, 'Too long (3 entries)');
	}
}

/* EOF */