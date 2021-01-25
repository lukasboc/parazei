<?php
require 'inc/session.php.inc';
include_once '../classes/DBJiraConnections.php';
$jiraConnections = new DBJiraConnections();

$id = $_POST['id'] ?? null;
$connectionName = $_POST['connectionName'] ?? null;
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$apivthree = $_POST['apivthree'] ?? null;

if ($connectionName == null || $id == null || $host == null || $username == null || $password == null) {
    $_SESSION['jiraConnectionId'] = $id;
    $_SESSION['jiraMsg'] = 'Bitte fülle alle Felder aus.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
if ($apivthree === null) {
    $apivthree = 0;
} elseif ($apivthree === 'true') {
    $apivthree = 1;
}

if ($jiraConnections->updateJiraConnection($id, $_SESSION['userid'], $connectionName, $host, $username, $password, $apivthree)) {
    $_SESSION['jiraConnectionId'] = $id;
    $_SESSION['jiraMsg'] = 'Verbindung erfolgreich bearbeitet.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $_SESSION['jiraConnectionId'] = $id;
    $_SESSION['jiraMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}