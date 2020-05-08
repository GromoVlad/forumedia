<?php

namespace Application\Models;

use Config\Config;

class IndexModel
{
    const TITLE = 'Список пользователей';
    const CSS = 'index';
    public $path;
    private $connectDB;
    private $header;

    public function __construct()
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel();
        $this->path = Config::APP_URL;
    }

    public function render($file)
    {
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function getDataUser()
    {
        $sql = "SELECT id, login, email, name, surname,  phone, image, address, date_create, 
                date_update, active, club_type FROM clients WHERE id = ?";
        $category = [];
        $category[] = $_SESSION['login']['id'];
        return $this->connectDB->queryDB($sql, $category);
    }

    public function updateUser()
    {
        (new Validator($_POST))->validationBeforeUpdateUser($_SESSION['login']['id']); // валидация всех полей
        if (empty($_SESSION['reg']['errors'])) {
            if (empty($_POST['password'])) {
                $sql = "UPDATE `clients` SET login = ?, email = ?, name = ?, surname = ?, phone = ?, 
                        image = ?, address = ?, date_update = ? WHERE id = ?";
            } else {
                $sql = "UPDATE `clients` SET login = ?, password = ?, email = ?, name = ?, surname = ?, phone = ?, 
                        image = ?, address = ?, date_update = ? WHERE id = ?";
            }
            $category = (new PreparingDataSQL($_POST, $_FILES))->generateDataBeforeUpdatingUser($_SESSION['login']['id']); // подготавливаем данные для передачи в БД
            $this->connectDB->queryDB($sql, $category);
            return true;
        }
        return false;
    }

    public function deleteUser()
    {
        $id = $_SESSION['login']['id'];
        $sql = "DELETE FROM clients WHERE id = ?";
        $category = [];
        $category[] = $id;
        $this->connectDB->queryDB($sql, $category);
    }

    public function isEmpty($data)
    {
        if (empty($data)) {
            return 'Нет данных';
        } else {
            return $data;
        }
    }

    public function userIsActive($active)
    {
        if ($active) {
            return 'Активен';
        } elseif (!$active) {
            return 'Неактивен';
        }
    }

    public function userStatusClub($status)
    {
        if ($status === 'no') {
            return 'Не в клубе';
        } elseif ($status === 'standart') {
            return 'Стандарт';
        } elseif ($status === 'max') {
            return 'Максимум';
        }
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