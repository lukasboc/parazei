<?php
require 'inc/session.php.inc';
include_once '../classes/DBRedmineConnections.php';
$redmineConnections = new DBRedmineConnections();


$id = $_POST['id'] ?? null;
$connectionName = $_POST['connectionName'] ?? null;
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($connectionName == null || $id == null || $host == null || $username == null || $password == null) {
    $_SESSION['redmineConnectionId'] = $id;
    $_SESSION['redmineMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
if ($redmineConnections->updateRedmineConnection($id, $_SESSION['userid'], $connectionName, $host, $username, $password)) {
    $_SESSION['redmineConnectionId'] = $id;
    $_SESSION['redmineMsg'] = 'Verbindung erfolgreich bearbeitet.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $_SESSION['redmineConnectionId'] = $id;
    $_SESSION['redmineMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}