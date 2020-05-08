<?php

namespace Application\Models;

use Config\Config;
use PDO;

class DBModel
{
    private static $instance = null;

    private function __construct()
    {
        $dsn = 'mysql:host=' . Config::HOST_DB . ';dbname=' . Config::NAME_DB . ';charset=utf8';
        self::$instance = new PDO ($dsn, Config::LOGIN_DB, Config::PASS_DB);
    }

    public static function getInstance()
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        return new self;
    }

    public function queryDB($sql, $category = false)
    {
        $stmt = self::$instance->prepare($sql);
        if (!$category) {
            $stmt->execute();
        } else {
            $stmt->execute($category);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}