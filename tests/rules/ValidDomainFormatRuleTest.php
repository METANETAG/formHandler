<?php

namespace tests\rules;

use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\rule\ValidDomainFormatRule;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 * @version 1.0.0
 */
class ValidDomainFormatRuleTest extends \PHPUnit_Framework_TestCase {
	public function testValidDomainFormatRuleSingleValue() {
		$rule = new ValidDomainFormatRule('this field contains no valid domain');
		$field = new InputField('test', 'test');

		$field->setValue('');
		$this->assertSame($rule->validate($field), true, 'No input skipped');

		$field->setValue('abc');
		$this->assertSame($rule->validate($field), false, 'Invalid domain abc');

		$field->setValue('www.abc');
		$this->assertSame($rule->validate($field), false, 'Invalid domain www.abc');

		$field->setValue('http://www.abc');
		$this->assertSame($rule->validate($field), false, 'Invalid domain http://www.abc');

		$field->setValue('abc.ch');
		$this->assertSame($rule->validate($field), true, 'Valid domain abc.ch');

		$field->setValue('http://abc.ch');
		$this->assertSame($rule->validate($field), true, 'Valid domain http://abc.ch');

		$field->setValue('HTTP://WWW.abc.ch');
		$this->assertSame($rule->validate($field), true, 'Valid domain HTTP://WWW.abc.ch');

		$field->setValue('https://abc.ch');
		$this->assertSame($rule->validate($field), true, 'Valid domain https://abc.ch');

		$field->setValue('ftp://abc.ch');
		$this->assertSame($rule->validate($field), true, 'Valid domain ftp://abc.ch');

		$field->setValue('fo://abc.ch');
		$this->assertSame($rule->validate($field), true, 'Invalid domain fo://abc.ch');
	}
}

/* EOF */