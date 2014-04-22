<?php

namespace test\rules;

use ch\timesplinter\formHandler\field\InputField;
use ch\timesplinter\formHandler\rule\MinLengthRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class MinLengthRuleTest extends \PHPUnit_Framework_TestCase {
	public function testMinLengthRule() {
		$rule = new MinLengthRule(2, 'too long');
		$field = new InputField('test', 'test');
		$field->setValue('abc');

		$this->assertSame($rule->validate($field), true, 'Long enough');

		$field->setValue('ab');
		$this->assertSame($rule->validate($field), true, 'On bounderies');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'Zero length');
	}
}

/* EOF */