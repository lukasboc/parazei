<?php
require 'inc/session.php.inc';
require_once '../classes/DBUsers.php';
require '../classes/ChangeMailChecker.php';
require_once '../classes/Mailer.php';
require __DIR__ . '/../vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

$dbUser = new DBUsers();
$changeMailChecker = new ChangeMailChecker();
$mailer = new Mailer();
$validator = new EmailValidator();
$multipleValidations = new MultipleValidationWithAnd([
    new RFCValidation(),
    new DNSCheckValidation()
]);


$newMail = $_POST['newMail'] ?? null;
$password = $_POST['password'] ?? null;

if (!$changeMailChecker->checkIfInputsFitRequirements($newMail, $password)) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if (!$validator->isValid($newMail, $multipleValidations)) {
    $_SESSION['mailMsg'] = 'Die E-Mail war nicht gültig.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($dbUser->updateMailOfUser($_SESSION['userid'], $newMail)) {
    if ($mailer->sendNewMailMessage($newMail)) {
        $_SESSION['mailMsg'] = 'Mail erfolgreich geändert. Kontrolliere dein Postfach.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
    $_SESSION['mailMsg'] = 'Mail erfolgreich geändert. Keine Mailzustellung möglich.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
$_SESSION['mailMsg'] = 'Fehler. Möglicherweise ist die Mail schon vergeben.';
header('Location: ' . $_SERVER['HTTP_REFERER']);