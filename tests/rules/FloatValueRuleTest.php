<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\rule\FloatValueRule;
use ch\metanet\formHandler\rule\MaxLengthRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class FloatValueRuleTest extends \PHPUnit_Framework_TestCase
{
	public function testDifferentFloatFormats()
	{
		$rule = new FloatValueRule('Not a valid float value');
		$field = new InputField('test', 'test');
		
		$field->setValue('abc');
		$this->assertSame(false, $rule->validate($field), 'String alphabetic value');

		$field->setValue('103');
		$this->assertSame(true, $rule->validate($field), 'String numeric value');

		$field->setValue(103);
		$this->assertSame(true, $rule->validate($field), 'Int numeric value');

		$field->setValue('');
		$this->assertSame(true, $rule->validate($field), 'Empty value');

		$field->setValue('10.3');
		$this->assertSame(true, $rule->validate($field), 'String float value');

		$field->setValue(10.3);
		$this->assertSame(true, $rule->validate($field), 'Float value');

		$field->setValue('10,3');
		$this->assertSame(true, $rule->validate($field), 'String float value with comma');

		$field->setValue('10:3');
		$this->assertSame(false, $rule->validate($field), 'Invalid decimal separator');

		$field->setValue('1\'000,35');
		$this->assertSame(true, $rule->validate($field), 'Float with period as thousand separator and comma as decimal separator');

		$field->setValue('1\'000.35');
		$this->assertSame(true, $rule->validate($field), 'Float with period as thousand separator and point as decimal separator');

		$field->setValue('1.000,35');
		$this->assertSame(true, $rule->validate($field), 'Float with point as thousand separator and comma as decimal separator');
	}
}

/* EOF */