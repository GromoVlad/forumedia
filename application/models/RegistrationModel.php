<?php

namespace Application\Models;

use Config\Config;

class RegistrationModel
{
    const TITLE = 'Регистрация';
    const CSS = 'registration';
    public $path;
    private $emailAdmin;
    private $header;
    private $request;
    private $file;

    public function __construct($request = null, $file = null)
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel;
        $this->path = Config::APP_URL;
        $this->emailAdmin = Config::EMAIL_ADMIN;
        $this->request = $request;
        $this->file = $file;
    }

    public function render($file)
    {
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function createUser()
    {
        (new Validator($this->request))->validationBeforeCreation(); // валидация всех полей
        if (empty($_SESSION['reg']['errors'])) {
            $sql = 'INSERT INTO `clients` (`login`, `password`, `email`, `name`, `surname`, `phone`, `image`,`address`, 
            `date_create`, `date_update`, `active`, `club_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $category = (new PreparingDataSQL($this->request, $this->file))->generateDataBeforeCreating();
            $this->connectDB->queryDB($sql, $category);
            return true;
        }
        return false;
    }

    public function getValueInput($nameInput)
    {
        return $this->request[$nameInput];
    }

    public function getAllErrors()
    {
        $errorString = '';
        if (!empty($_SESSION['reg']['errors'])) {
            foreach ($_SESSION['reg']['errors'] as $error) {
                $errorString .= "*$error <br />";
            }
        }
        return $errorString;
    }
}