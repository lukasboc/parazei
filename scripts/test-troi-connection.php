<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
include_once '../classes/TroiConnector.php';
$troiDBConenctions = new DBTroiConnections();
$troiConnector = new TroiConnector();

$id = null;
$name = null;

if (isset($_POST['troiConnectionId'])) {
    $id = $_POST['troiConnectionId'];
}
$troiConnection = $troiDBConenctions->getConnectionById($id, $_SESSION['userid']);
if ($troiConnection[0]['id'] == null) {
    $_SESSION['troiMsg'] = 'Hier scheint etwas schiefgelaufen zu sein.';
    header('Location: ../core/connections.php');
    die();
}
$name = $troiConnection[0]['name'];

if ($id !== null) {
    $clients = $troiConnector->testConnection($id);
    if ($clients !== null) {
        $_SESSION['troiMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong> steht! Es wurden ' . sizeof($clients) . ' Mandanten gefunden.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $_SESSION['troiMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong> steht <strong>nicht</strong>! Bitte prüfe alle Eingaben. Schaue im Zweifel in das Handbuch, um Informationen über gültige Eingaben zu erhalten.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}
$_SESSION['troiMsg'] = 'Hier scheint etwas schiefgelaufen zu sein.';
header('Location: ../core/connections.php');
die();