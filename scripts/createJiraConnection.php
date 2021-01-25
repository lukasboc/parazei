<?php
require 'inc/session.php.inc';
include_once '../classes/DBJiraConnections.php';
$jiraConnections = new DBJiraConnections();

$connectionName = $_POST['connectionName'] ?? null;
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$apivthree = $_POST['apivthree'] ?? null;

if ($connectionName == null || $host == null || $username == null || $password == null) {
    $_SESSION['jiraMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
if ($apivthree === null) {
    $apivthree = 0;
} elseif ($apivthree === 'true') {
    $apivthree = 1;
}

if ($jiraConnections->createJiraConnection($connectionName, $_SESSION['userid'], $host, $username, $password, $apivthree)) {
    $_SESSION['jiraMsg'] = 'Verbindung erfolgreich erstellt.';
    header('Location: ../core/connections.php');
} else {
    $_SESSION['jiraMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}