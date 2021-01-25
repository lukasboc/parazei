<?php
require 'inc/session.php.inc';
require '../classes/PasswordChecker.php';
require_once '../classes/Mailer.php';
require_once '../classes/DBUsers.php';

$dbUsers = new DBUsers();
$passwordChecker = new PasswordChecker();
$mailer = new Mailer();

$currentPassword = $_POST['currentPassword'] ?? null;
$newPasswordOne = $_POST['newPasswordOne'] ?? null;
$newPasswordTwo = $_POST['newPasswordTwo'] ?? null;

if (!$passwordChecker->checkIfInputsFitRequirements($currentPassword, $newPasswordOne, $newPasswordTwo)) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if (!$dbUsers->checkPasswordByUid($_SESSION['userid'], $currentPassword)) {
    $_SESSION['msg'] = 'Das aktuelle Passwort war falsch.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($dbUsers->updatePasswordOfUser($_SESSION['userid'], $newPasswordOne)) {
    if ($mailer->sendNewPasswordInfoMail($dbUsers->getMailByUserId($_SESSION['userid']))) {
        $_SESSION['msg'] = 'Passwort erfolgreich geändert. Kontrolliere dein Postfach.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
    $_SESSION['msg'] = 'Passwort erfolgreich geändert. Eine Bestätigungsmail konnte nicht zugestellt werden.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
$_SESSION['msg'] = 'Datenbankfehler. Versuche es später nochmal oder kontaktiere den Support.';
header('Location: ' . $_SERVER['HTTP_REFERER']);