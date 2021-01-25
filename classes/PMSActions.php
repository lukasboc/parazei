<?php
/**
 * Created by PhpStorm.
 * User: lukasbock
 * Date: 05.09.20
 * Time: 13:42
 */

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Noodlehaus\Config;


abstract class PMSActions
{
    public function __construct()
    {
        $this->createLogger();
    }

    public function createLogger()
    {
        $logger = new Logger('logger');
        $conf = new Config('../config/general-config.php');
        if ($conf->get('dbLogging') === ('DEBUG')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::DEBUG));
        }
        if ($conf->get('dbLogging') === ('NOTICE')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::NOTICE));
        }
        if ($conf->get('dbLogging') === ('INFO')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::INFO));
        }
        if ($conf->get('dbLogging') === ('ERROR')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::ERROR));
        }
        if ($conf->get('dbLogging') === ('CRITICAL')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::CRITICAL));
        }
        if ($conf->get('dbLogging') === ('ALERT')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::ALERT));
        }
        if ($conf->get('dbLogging') === ('EMERGENCY')) {
            return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::EMERGENCY));
        }
        return $logger->pushHandler(new StreamHandler('../logs/pms-actions' . date("Ymd") . '.log', Logger::WARNING));
    }
}