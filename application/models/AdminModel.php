<?php

namespace Application\Models;

use Config\Config;

class AdminModel
{
    const TITLE = 'Панель администратора';
    const CSS = 'admin';
    public $path;
    public $params;
    private $recordsInPage;
    private $connectDB;
    private $header;

    public function __construct()
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel;
        $this->path = Config::APP_URL;
        $this->recordsInPage = Config::RECORDS_IN_PAGE;  // убрать
    }

    public function render($file)
    {
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function getUsers()
    {
        $from = empty($this->params['page']) ? 0 : (($this->params['page'] - 1) * Config::RECORDS_IN_PAGE);
        $notesOnPage = $this->recordsInPage;
        $sql = "SELECT id, login, name, surname, email, date_create, active, club_type FROM clients WHERE 1=1";
        if (isset($this->params['status'])) {
            $status = $this->params['status'];
            $sql .= " AND active = $status ";
        }
        if (!empty($this->params['symbol'])) {
            $symbol = urldecode($this->params['symbol']);
            $sql .= " AND surname LIKE '$symbol%' ";
        }
        $sql .= " LIMIT $from, $notesOnPage";
        return $this->connectDB->queryDB($sql);
    }

    public function updateUser()
    {
        (new Validator($_POST))->validationBeforeUpdateAdmin($this->params['id']); // валидация
        if (empty($_SESSION['reg']['errors'])) {
            $category = (new PreparingDataSQL($_POST, $_FILES))->generateDataBeforeUpdatingAdmin($this->params['id']);  // подготавливаем данные для передачи в БД
            $sql = "UPDATE `clients` SET login = ?, email = ?, name = ?, surname = ?, phone = ?, image = ?, 
                    address = ?, date_update = ?, active = ?, club_type = ? WHERE id = ?";
            $this->connectDB->queryDB($sql, $category);
            return true;
        }
        return false;
    }

    private function changeActive($id) // отправляем письмо о успешной регистрации пользователю и админу
    {
        $sql = "SELECT active FROM clients WHERE id = ?";
        $category = [];
        $category[] = $id;
        $result = $this->connectDB->queryDB($sql, $category);
        return $result[0]['active'];
    }

    public function deleteUser()
    {
        $id = $this->params['id'];
        $sql = "DELETE FROM clients WHERE id = ?";
        $category = [];
        $category[] = $id;
        $this->connectDB->queryDB($sql, $category);
    }

    public function createUser()
    {
        (new Validator($_POST))->validationBeforeCreation(); // валидация всех полей
        if (empty($_SESSION['reg']['errors'])) {
            $sql = 'INSERT INTO `clients` (`login`, `password`, `email`, `name`, `surname`, `phone`, `image`,`address`, 
            `date_create`, `date_update`, `active`, `club_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $category = (new PreparingDataSQL($_POST, $_FILES))->generateDataBeforeCreating();
            $this->connectDB->queryDB($sql, $category);
            return true;
        }
        return false;
    }

    public function pagination()
    {
        $sql = "SELECT id FROM clients WHERE 1=1";
        if (isset($this->params['status'])) {
            $status = $this->params['status'];
            $sql .= " AND active = $status ";
        }
        if (!empty($this->params['symbol'])) {
            $symbol = urldecode($this->params['symbol']);
            $sql .= " AND surname LIKE '$symbol%' ";
        }
        $allRecords = count($this->connectDB->queryDB($sql));
        $numberPages = ceil($allRecords / $this->recordsInPage);
        $pagination = '';
        for ($i = 1; $i <= $numberPages; $i++) {
            if (isset($this->params['status'])) {
                $pagination .= '<a href="' . $this->path . 'admin/index/page/' . $i . '/status/' . $status . '" class="link">' . $i . '</a>';
            } elseif (!empty($this->params['symbol'])) {
                $pagination .= '<a href="' . $this->path . 'admin/index/page/' . $i . '/symbol/' . $symbol . '" class="link">' . $i . '</a>';
            } else {
                $pagination .= '<a href="' . $this->path . 'admin/index/page/' . $i . '" class="link">' . $i . '</a>';
            }
        }
        return $pagination;
    }

    public function getFirstLettersSurnames()
    {
        $sql = "SELECT surname FROM clients";
        $allSurnameDB = $this->connectDB->queryDB($sql);
        $allSurname = [];
        foreach ($allSurnameDB as $surname) {
            $allSurname[] = mb_substr($surname['surname'], 0, 1);
        }
        $result = array_unique($allSurname);
        sort($result);
        return $result;
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

    public function getUser()
    {
        $category = [];
        $category[] = $this->params['id'];
        $sql = "SELECT id, login, password, email, name, surname, phone, image, address, date_create, 
                date_update, active, club_type FROM clients WHERE id = ?";
        return $this->connectDB->queryDB($sql, $category);
    }

    public function isEmpty($data)
    {
        if (empty($data)) {
            return 'Нет данных';
        } else {
            return $data;
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

    public function getValueInput($nameInput)
    {
        return $this->POST[$nameInput];
    }

    public function clearErrorBuffer()
    {
        unset($_SESSION['reg']['errors']);
    }
}