<?php
require 'inc/session.php.inc';
include_once '../classes/DBRedmineConnections.php';
$redmineConnections = new DBRedmineConnections();

$id = $_POST['id'] ?? null;

if ($id == null) {
    $_SESSION['redmineConnectionId'] = $id;
    $_SESSION['redmineMsg'] = 'Die Löschung ist fehlgeschlagen, weil die ID unterwegs verloren gegangen ist. Versuche es bitte erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
if ($redmineConnections->deleteConnection($id, $_SESSION['userid'])) {
    $_SESSION['redmineMsg'] = 'Verbindung erfolgreich entfernt.';
    header('Location: ../core/connections.php');
} else {
    $_SESSION['redmineConnectionId'] = $id;
    $_SESSION['redmineMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}