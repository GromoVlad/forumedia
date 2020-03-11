<?php

class AdminModel
{
    const TITLE = 'Панель администратора';
    const CSS = 'admin';
    public $path;
    public $params;
    private $recordsInPage;

    public function __construct()
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel;
        $config = new Config();
        $this->path = $config::APP_URL;
        $this->recordsInPage = $config::RECORDS_IN_PAGE;
    }

    public function render($file)
    {
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function getUsers()
    {
        $from = empty($this->params['page']) ? 0 : (($this->params['page'] - 1) * $this->recordsInPage);
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
        $result = $this->connectDB->queryDB($sql);
        return $result;
    }

    public function updateUser()
    {
        $id = $this->params['id'];
        $validator = new Validator($_POST);
        $validator->validationBeforeUpdateAdmin($id); // валидация
        if (empty($_SESSION['reg']['errors'])) {
            $preparingDataSQL = new PreparingDataSQL($_POST, $_FILES);
            $category = $preparingDataSQL->generateDataBeforeUpdatingAdmin($id);  // подготавливаем данные для передачи в БД
            $sql = "UPDATE `clients` SET login = ?, email = ?, name = ?, surname = ?, phone = ?, image = ?, 
            address = ?, date_update = ?, active = ?, club_type = ? WHERE id = ?";
            $needEmail = $this->changeActive($id) == $category[8] ? false : true; // проверяем изменился ли статус активности?
            $this->connectDB->queryDB($sql, $category);
            // отправляем письмо пользователю о изменении его статуса администратором
            if ($needEmail) {
                $mail = new Mailer($_POST);
                $mail->sendMailChangeActive($category[8], $category[1]);
            }
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
        $validator = new Validator($_POST);
        $validator->validationBeforeCreation(); // валидация всех полей
        if (empty($_SESSION['reg']['errors'])) {
            $sql = 'INSERT INTO `clients` (`login`, `password`, `email`, `name`, `surname`, `phone`, `image`,`address`, 
            `date_create`, `date_update`, `active`, `club_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $preparingDataSQL = new PreparingDataSQL($_POST, $_FILES);
            $category = $preparingDataSQL->generateDataBeforeCreating();
            $this->connectDB->queryDB($sql, $category);
            $this->sendMail();  // отправляем письмо о успешной регистрации пользователю и администратору
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
        $sql = "SELECT id, login, password, email, name, surname, phone, image, address, date_create, date_update, 
                active, club_type FROM clients WHERE id = ?";
        $result = $this->connectDB->queryDB($sql, $category);
        return $result;
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

    private function sendMail() // отправляем письмо о успешной регистрации пользователю и админу
    {
        $mail = new Mailer($_POST);
        $mail->sendMailUser();
        $mail->sendMailAdmin();
    }
}