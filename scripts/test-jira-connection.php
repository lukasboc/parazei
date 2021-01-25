<?php
require 'inc/session.php.inc';
include_once '../classes/DBJiraConnections.php';
include_once '../classes/JiraConnector.php';
$jiraDBConnections = new DBJiraConnections();
$jiraConnector = new JiraConnector();

$id = null;
$name = null;
if (isset($_POST['jiraConnectionId'])) {
    $id = $_POST['jiraConnectionId'];
}

$jiraConnection = $jiraDBConnections->getConnectionById($id, $_SESSION['userid']);
if ($jiraConnection[0]['id'] == null) {
    $_SESSION['jiraMsg'] = 'Hier scheint etwas schiefgelaufen zu sein.';
    header('Location: ../core/connections.php');
    die();
}
$name = $jiraConnection[0]['name'];

if ($id !== null) {
    $user = $jiraConnector->testConnection($id);
    if ($user !== null) {
        $_SESSION['jiraMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong> zu steht, ' . $user->displayName . '!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $_SESSION['jiraMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong>  konnte <strong>nicht</strong> hergestellt werden. Prüfe deine Eingaben und stelle auch sicher, dass du einen API-Token und kein Passwort eingegeben hast.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}
$_SESSION['jiraMsg'] = 'Hier scheint etwas schiefgelaufen zu sein.';
header('Location: ../core/connections.php');
die();