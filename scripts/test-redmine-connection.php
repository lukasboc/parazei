<?php
require 'inc/session.php.inc';
include_once '../classes/DBRedmineConnections.php';
include_once '../classes/RedmineConnector.php';
$redmineDBConenctions = new DBRedmineConnections();
$redmineConnector = new RedmineConnector();

$id = null;
$name = null;

if (isset($_POST['redmineConnectionId'])) {
    $id = $_POST['redmineConnectionId'];
}
$redmineConnection = $redmineDBConenctions->getConnectionById($id, $_SESSION['userid']);
if ($redmineConnection[0]['id'] == null) {
    $_SESSION['redmineMsg'] = 'Hier ist etwas schiefgelaufen.';
    header('Location: ../core/connections.php');
    die();
}
$name = $redmineConnection[0]['name'];

if ($id !== null) {
    $user = $redmineConnector->testConnection($id);
    if ($user !== null) {
        $_SESSION['redmineMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong> steht, ' . $user['user']['firstname'] . ' ' . $user['user']['lastname'] . '!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $_SESSION['redmineMsg'] = 'Die Verbindung zu <strong>' . $name . '</strong>  konnte <strong>nicht</strong> hergestellt werden. Prüfe deine Eingaben und schaue im Zweifel in das Handbuch, um Informationen über gültige Eingaben zu erhalten.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}
$_SESSION['redmineMsg'] = 'Hier ist etwas schiefgelaufen.';
header('Location: ../core/connections.php');
die();
