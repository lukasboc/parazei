<?php
require '../classes/DBConnector.php';
require __DIR__ . '../../../vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION['userid'])) {
        $_SESSION['userid'];
        header('Location: ../start/index.php?error=not-logged-in');
    }
}