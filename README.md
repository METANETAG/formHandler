formHandler
===========

[![Latest Stable Version](https://poser.pugx.org/metanet/form-handler/v/stable.svg)](https://packagist.org/packages/metanet/form-handler)
[![Build Status](https://travis-ci.org/METANETAG/formHandler.svg)](https://travis-ci.org/METANETAG/formHandler)

This is a library for handling web based forms written in PHP. It takes care about verifying and rendering form components.

Basic requirements of the formHandler library are:

* easy to use - without a lot of knowledge depending on processing forms in PHP.
* efficiency boost - the library should generalize things you have to redo for each and every form and field in it

[See the wiki](http://github.com/METANETAG/formHandler/wiki) for more information about how to use the library.

Quick code example:

```php
<?php

$myForm = new Form();
$myForm->setInputData(array_merge($_GET, $_POST));

$myField = new InputField('my_field', 'My field');
$myField->addRule(new RequiredRule('Please insert a value for my field'));

$myForm->addComponent($myField);

if($myForm->isSent() === true && $myForm->validate() === true) {
	echo 'Form sent to the server and validated successfully!';
} else {
	echo 'There have been errors during validation. Please check the red marked fields below.';
}

echo $myForm->render();

/* EOF */
```