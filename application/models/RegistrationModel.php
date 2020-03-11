<?php

class RegistrationModel
{
    const TITLE = 'Регистрация';
    const CSS = 'registration';
    public $path;
    private $emailAdmin;

    public function __construct($request = null, $file = null)
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel;
        $config = new Config();
        $this->path = $config::APP_URL;
        $this->emailAdmin = $config::EMAIL_ADMIN;
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
        $validator = new Validator($this->request);
        $validator->validationBeforeCreation(); // валидация всех полей
        if (empty($_SESSION['reg']['errors'])) {
            $sql = 'INSERT INTO `clients` (`login`, `password`, `email`, `name`, `surname`, `phone`, `image`,`address`, 
            `date_create`, `date_update`, `active`, `club_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $preparingDataSQL = new PreparingDataSQL($this->request, $this->file);
            $category = $preparingDataSQL->generateDataBeforeCreating();
            $this->connectDB->queryDB($sql, $category);
            $this->sendMail();  // отправляем письмо о успешной регистрации пользователю и админу
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

    private function sendMail() // отправляем письмо о успешной регистрации пользователю и админу
    {
        $mail = new Mailer($this->request);
        $mail->sendMailUser();
        $mail->sendMailAdmin();
    }
}