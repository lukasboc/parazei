<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
$troiConnections = new DBTroiConnections();

$connectionName = $_POST['connectionName'] ?? null;
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($connectionName == null || $host == null || $username == null || $password == null) {
    $_SESSION['troiMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($troiConnections->createTroiConnection($connectionName, $_SESSION['userid'], $host, $username, $password)) {
    $_SESSION['troiMsg'] = 'Verbindung erfolgreich erstellt.';
    header('Location: ../core/connections.php');
} else {
    $_SESSION['troiMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}