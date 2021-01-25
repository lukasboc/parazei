<?php

include_once "../classes/DBConnector.php";

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Noodlehaus\Config;
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

abstract class DBActions
{
    protected $connection;

    public function getEncryptionKey()
    {
        $keyAscii = file_get_contents('../config/encryption-key.txt');
        return Key::loadFromAsciiSafeString($keyAscii);

    }

    public function encryptValue($value)
    {
        $key = $this->getEncryptionKey();
        $ciphertext = Crypto::encrypt($value, $key);
        return $ciphertext;
    }

    public function decryptValue($value)
    {
        $key = $this->getEncryptionKey();
        $ciphertext = $value;
        try {
            $secret_data = Crypto::decrypt($ciphertext, $key);
            return $secret_data;
        } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
            $this->createLogger()->alert('Error while decrypt userdata from DB. Either the wrong key was loaded, or the ciphertext has changed since it was created (either corrupted in the database or intentionally modified trying to carry out an attack).');
            // An attack! Either the wrong key was loaded, or the ciphertext has
            // changed since it was created -- either corrupted in the database or
            // intentionally modified trying to carry out an attack.
        }
    }

    public function __construct()
    {
        $this->createConnection();
        $this->createLogger();
    }

    public function getConnection(){
        return $this->connection;
    }

    public function createConnection(): PDO
    {
        $dbConnector = new DBConnector();
        $this->connection = $dbConnector->connect();
        return $this->connection;
    }

    public function createLogger()
    {
        $logger = new Logger('logger');
        $conf = new Config('../config/general-config.php');
        if ($conf->get('dbLogging') === ('DEBUG')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::DEBUG));
        }
        if ($conf->get('dbLogging') === ('NOTICE')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::NOTICE));
        }
        if ($conf->get('dbLogging') === ('INFO')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::INFO));
        }
        if ($conf->get('dbLogging') === ('ERROR')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::ERROR));
        }
        if ($conf->get('dbLogging') === ('CRITICAL')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::CRITICAL));
        }
        if ($conf->get('dbLogging') === ('ALERT')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::ALERT));
        }
        if ($conf->get('dbLogging') === ('EMERGENCY')) {
            return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::EMERGENCY));
        }
        return $logger->pushHandler(new StreamHandler('../logs/db-actions' . date("Ymd") . '.log', Logger::WARNING));
    }
}