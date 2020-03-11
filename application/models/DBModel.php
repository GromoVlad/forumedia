<?php

class DBModel
{
    private static $_instance = null;

    private function __construct()
    {
        $config = new Config();
        $dsn = 'mysql:host=' . $config::HOST_DB . ';dbname=' . $config::NAME_DB . ';charset=utf8';
        $this->_instance = new PDO ($dsn, $config::LOGIN_DB, $config::PASS_DB);
    }

    public static function getInstance()
    {
        if (self::$_instance != null) {
            return self::$_instance;
        }
        return new self;
    }

    public function __destruct()
    {
        $this->_instance = null;
    }

    public function queryDB($sql, $category = false)
    {
        $stmt = $this->_instance->prepare($sql);
        if (!$category) {
            $stmt->execute();
        } else {
            $stmt->execute($category);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}