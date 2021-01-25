<?php
require 'inc/session.php.inc';
include_once '../classes/DBTroiConnections.php';
$troiConnections = new DBTroiConnections();

$id = $_POST['id'] ?? null;

if ($id == null) {
    $_SESSION['troiConnectionId'] = $id;
    $_SESSION['troiMsg'] = 'Die Löschung ist fehlgeschlagen, weil die ID unterwegs verloren gegangen ist. Versuche es bitte erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($troiConnections->deleteConnection($id, $_SESSION['userid'])) {
    $_SESSION['troiMsg'] = 'Verbindung erfolgreich entfernt.';
    header('Location: ../core/connections.php');
} else {
    $_SESSION['troiConnectionId'] = $id;
    $_SESSION['troiMsg'] = 'Hier ist etwas schief gelaufen. Versuche es erneut.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}