<?php

namespace test\rules;

use ch\timesplinter\formHandler\field\InputField;
use ch\timesplinter\formHandler\rule\MaxLengthRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class MaxLengthRuleTest extends \PHPUnit_Framework_TestCase {
	public function testMaxLengthRule() {
		$rule = new MaxLengthRule(2, 'too long');
		$field = new InputField('test', 'test');
		$field->setValue('abc');

		$this->assertSame($rule->validate($field), false);

		$field->setValue('ab');
		$this->assertSame($rule->validate($field), true);

		$field->setValue('');
		$this->assertSame($rule->validate($field), true);
	}
}

/* EOF */