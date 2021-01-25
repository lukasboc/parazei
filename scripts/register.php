<?php

include '../classes/PasswordChecker.php';
include '../classes/DBUsers.php';
require_once '../classes/Mailer.php';
require __DIR__ . '/../vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

$registrationChecker = new PasswordChecker();
$dbUsers = new DBUsers();
$mailer = new Mailer();
$validator = new EmailValidator();
$multipleValidations = new MultipleValidationWithAnd([
    new RFCValidation(),
    new DNSCheckValidation()
]);

$mail = $_POST['email'] ?? null;
$passwordOne = $_POST['passwordOne'] ?? null;
$passwordTwo = $_POST['passwordTwo'] ?? null;


if (!$registrationChecker->checkIfInputsFitRequirements($mail, $passwordOne, $passwordTwo)) {
    header('Location: ../start/index.php?msg=error-requirements');
    die();
}

if (!$validator->isValid($mail, $multipleValidations)) {
    header('Location: ../start/index.php?msg=error-valid-email');
    die();
}
if ($dbUsers->register($mail, $passwordOne)) {
    if ($mailer->sendRegistrationMain($mail)) {
        header('Location: ../start/index.php?msg=registration-successfull');
        die();
    }
    header('Location: ../start/index.php?msg=registration-successfull-no-mail');
    die();
}
header('Location: ../start/index.php?msg=registration-error');
die();
