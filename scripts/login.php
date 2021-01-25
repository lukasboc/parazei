<?php
require '../classes/DBUsers.php';
$dbUsers = new DBUsers();

$mail = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($mail == null || $password == null) {
    header('Location: ../start/index.php?msg=empty-input');
    die();
}

$success = $dbUsers->login($mail, $password);
if ($success) {
    session_start();
    $userId = $dbUsers->getUserIdByMail($mail);
    $_SESSION['userid'] = $userId;
    header('Location: ../core/worklog.php');
} else {
    header('Location: ../start/index.php?msg=could-not-login');
}