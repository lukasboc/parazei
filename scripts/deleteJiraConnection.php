<?php
require 'inc/session.php.inc';
include_once '../classes/DBJiraConnections.php';
$jiraConnections = new DBJiraConnections();

$id = $_POST['id'] ?? null;

if ($id == null) {
    $_SESSION['jiraConnectionId'] = $id;
    $_SESSION['jiraMsg'] = 'Die Löschung ist fehlgeschlagen, weil die ID unterwegs verloren gegangen ist. Versuche es bitte erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($jiraConnections->deleteConnection($id, $_SESSION['userid'])) {
    $_SESSION['jiraMsg'] = 'Verbindung erfolgreich entfernt.';
    header('Location: ../core/connections.php');
} else {
    $_SESSION['jiraConnectionId'] = $id;
    $_SESSION['jiraMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}