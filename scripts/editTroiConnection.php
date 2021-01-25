<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
$troiConnections = new DBTroiConnections();

$id = $_POST['id'] ?? null;
$connectionName = $_POST['connectionName'] ?? null;
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($connectionName == null || $id == null || $host == null || $username == null || $password == null) {
    $_SESSION['troiConnectionId'] = $id;
    $_SESSION['troiMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($troiConnections->updateTroiConnection($id, $_SESSION['userid'], $connectionName, $host, $username, $password)) {
    $_SESSION['troiConnectionId'] = $id;
    $_SESSION['troiMsg'] = 'Verbindung erfolgreich bearbeitet.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $_SESSION['troiConnectionId'] = $id;
    $_SESSION['troiMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}