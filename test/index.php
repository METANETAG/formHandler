<?php

namespace test;

use ch\metanet\formHandler\field\DateField;
use ch\metanet\formHandler\field\DateTimeField;
use ch\metanet\formHandler\field\FileField;
use ch\metanet\formHandler\field\InputField;
use ch\metanet\formHandler\field\OptionsField;
use ch\metanet\formHandler\FormHandler;
use ch\metanet\formHandler\listener\FileFieldListener;
use ch\metanet\formHandler\renderer\EmailInputFieldRenderer;
use ch\metanet\formHandler\renderer\RadioOptionsFieldRenderer;
use ch\metanet\formHandler\renderer\SelectDateFieldRenderer;
use ch\metanet\formHandler\renderer\SelectMultipleOptionsFieldRenderer;
use ch\metanet\formHandler\renderer\SelectTimeFieldRenderer;
use ch\metanet\formHandler\renderer\TextareaInputFieldRenderer;
use ch\metanet\formHandler\renderer\TextDateFieldRenderer;
use ch\metanet\formHandler\rule\MinLengthRule;
use ch\metanet\formHandler\rule\RequiredRule;
use ch\metanet\formHandler\rule\ValidEmailAddressRule;

require 'autoloader.php';

date_default_timezone_set('Europe/Berlin');

// Options
$genderOptions = array(
	1 => 'male',
	2 => 'female',
	3 => 'other'
);

$hobbyOptions = array(
	'gaming' => array(
		'shooter' => array(
			11 => 'Call of Duty',
			13 => 'Half-Life'
		),
		'strategy' => array(
			14 => 'Farm ville'
		)
	),
	'other rubbish' => array(
		2 => 'clubbing',
		3 => 'playing football',
		4 => 'playing piano'
	)
);

class MyFileListener extends FileFieldListener {
	private $uploadPath;

	public function __construct($uploadPath) {
		$this->uploadPath = $uploadPath;
	}

	public function onUploadSuccess(FormHandler $formHandler, FileField $field) {
		$fileInfo = $field->getValue();
		$toPath = $this->uploadPath . $fileInfo['name'];

		if(move_uploaded_file($fileInfo['tmp_name'], $toPath) === false)
			$field->addError('Could not move file to: ' . $toPath);
	}
}

// Fields
$fldGender = new OptionsField('gender', 'Gender', $genderOptions, array(
	new RequiredRule('Please select a gender')
));
$fldGender->setFieldRenderer(new RadioOptionsFieldRenderer());

$fldName = new InputField('name', 'Name', array(
	new RequiredRule('Please insert your name here'),
	new MinLengthRule(3, 'The name you insert has to be at least 3 chars long')
));

$fldEmail = new InputField('email', 'E-Mail', array(
	new ValidEmailAddressRule('Please enter a valid e-mail address')
));
$fldEmail->setInputFieldRenderer(new EmailInputFieldRenderer());

$fldHobbies = new OptionsField('hobbies', 'Hobbies', $hobbyOptions, array(
	new RequiredRule('Please select at least 2 hobbies'),
	new MinLengthRule(2, 'Please select at least 2 hobbies')
));
$fldHobbies->setFieldRenderer(new SelectMultipleOptionsFieldRenderer());
$fldNote = new InputField('remark', 'Remark');
$fldNote->setInputFieldRenderer(new TextareaInputFieldRenderer());
$fldFile = new FileField('attachment', 'Attachment');
$fldFile->addListener(new MyFileListener(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR));

$fldBirthDate = new DateTimeField('birth_date', 'Birth date');
//$fldBirthDate->addRule(new RequiredRule('Please enter your birth date (required!)'));
/*$birthDateRenderer = new SelectDateFieldRenderer();
$birthDateRenderer->setLocalizedMonth(SelectDateFieldRenderer::LOCALIZED_MONTH_SHORT);
$fldBirthDate->setDateFieldRenderer($birthDateRenderer);
$fldBirthDate->setTimeFieldRenderer(new SelectTimeFieldRenderer(15, 30));*/
$fldBirthDate->setDateFieldRenderer(new TextDateFieldRenderer());

// FormHandler init
$fh = new FormHandler();
$fh->setInputData(array_merge($_GET, $_POST, $_FILES));
$fh->setFields(array(
	$fldGender,
	$fldName,
	$fldEmail,
	$fldHobbies,
	$fldNote,
	$fldFile,
	$fldBirthDate
));

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>FormHandler</title>

		<link rel="stylesheet" href="css/form-styles.css">
	</head>
	<body>
	<h1>Sample form</h1>
	<form action="?send" method="post" enctype="multipart/form-data">
	<?php

	if($fh->isSent() && $fh->validate()) {
		var_dump($fh->getFieldsKeyValueMap());
		die('Alles gut! Können wir speichern!');
	}

	echo $fh->renderFormComponent($fldGender);
	echo $fh->renderFormComponent($fldName);
	echo $fh->renderFormComponent($fldEmail);
	echo $fh->renderFormComponent($fldHobbies);
	echo $fh->renderFormComponent($fldNote);
	echo $fh->renderFormComponent($fldFile);
	echo $fh->renderFormComponent($fldBirthDate);

	?>
		<div class="submit">
			<input type="submit" value="send">
		</div>
	</form>
	</body>
</html>