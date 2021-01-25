<?php
include_once '../classes/DBUsers.php';
require_once '../classes/Mailer.php';

$dbUsers = new DBUsers();
$mailer = new Mailer();

$email = $_POST['email'] ?? null;
$userId = null;

if ($email == null) {
    header('Location: ../start/forgot-password.php?msg=empty-field');
    die();
}

if ($dbUsers->getUserIdByMail($email) !== null) {
    $userId = $dbUsers->getUserIdByMail($email);
} else {
    header('Location: ../start/forgot-password.php?msg=mail-not-found');
    die();
}

$generatedPass = substr((md5(microtime())), rand(0, 26), 8);
if ($dbUsers->updatePasswordOfUser($userId, $generatedPass)) {
    if ($mailer->sendNewPassword($email, $generatedPass)) {
        header('Location: ../start/forgot-password.php?msg=success');
        die();
    }
    header('Location: ../start/forgot-password.php?msg=success-no-mail');
    die();
}

$_SESSION['resetMsg'] = 'Das Passwort wurde <strong>nicht</strong> geändert. Versuche es erneut.';
header('Location: ../start/forgot-password.php?msg=error');
die();