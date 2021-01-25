<?php

require __DIR__ . '/../vendor/autoload.php';

use Noodlehaus\Config;

class DBConnector
{
    public function connect()
    {
        try {
            $conf = new Config('../config/db-config.php');
            return new PDO('mysql:host=' . $conf->get('mysqlhost') . ';dbname=' . $conf->get('mysqldbname'), $conf->get('mysqluser'), $conf->get('mysqlpassword'));
        } catch (Exception $exception) {
            echo 'An error occurred:' . $exception->getMessage();
        }
    }
}