<?php

class LoginModel
{
    const TITLE = 'Вход/регистрация';
    const CSS = 'login';
    public $path;

    public function __construct()
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->header = new HeaderModel;
        $config = new Config();
        $this->path = $config::APP_URL;
    }

    public function render($file) // $file - текущее представление
    {
        ob_start();
        include($file);
        return ob_get_clean();
    }

    public function getLogin()
    {
        if (!empty($_POST['login'])) {
            return $_POST['login'];
        }
    }

    public function verificationLogin($request)
    {
        $this->clearErrorBuffer(); // очищаем сессии от старых ошибок

        $admin = $this->searchAdmin($request); // сначала проверяем являются ли логин/пароль админскими
        if (!empty($admin)) {
            $_SESSION['login']['id'] = $admin['id'];
            $_SESSION['login']['user_login'] = $admin['login'];
            $_SESSION['login']['isAdmin'] = true;
            return; // в случае успеха дальнейшие проверки не осуществляются
        }

        $user = $this->searchUser($request); //проверяем являются ли логин/пароль пользовательскими
        if (!empty($user)) {
            $_SESSION['login']['id'] = $user['id'];
            $_SESSION['login']['user_login'] = $user['login'];
        } else {
            $_SESSION['login']['errors'] = '*Неверный логин или пароль';
        }
    }

    public function getError()
    {
        if (!empty($_SESSION['login']['errors'])) {
            $errors = $_SESSION['login']['errors'];
            unset ($_SESSION['login']);
            return $errors;
        }
    }

    private function searchAdmin($request)
    {
        if (isset($request['login'], $request['password'])) {
            $category = [];
            $category[] = $request['login'];
            $category[] = md5($request['password']);
            $sql = "SELECT id, login FROM admins WHERE (login = ? AND password = ?)";
            $response = $this->connectDB->queryDB($sql, $category);
            return $response[0];
        }
    }

    private function searchUser($request)
    {
        if (isset($request['login'], $request['password'])) {
            $category = [];
            $category[] = $request['login'];
            $category[] = md5($request['password']);
            $sql = "SELECT id, login FROM clients WHERE (login = ? AND password = ?)";
            $response = $this->connectDB->queryDB($sql, $category);
            return $response[0];
        }
    }

    private function clearErrorBuffer()
    {
        unset($_SESSION['login']['errors']);
    }
}