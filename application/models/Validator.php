<?php

class Validator
{
    const MIN_LENGTH_LOGIN = 5;
    const MIN_LENGTH_PASSWORD = 6;
    const MIN_LENGTH_NAME = 3;
    const MIN_LENGTH_SURNAME = 3;

    public function __construct($request)
    {
        $this->connectDB = DBModel::getInstance(); // подключение к БД
        $this->clearErrorBuffer();
        $this->request = $request;
    }

    public function validationBeforeCreation() // валидация всех полей при регистрации нового пользователя
    {
        $this->clearErrorBuffer(); // очищаем сессии от старых ошибок
        $this->loginNoEmpty()->checkLengthLogin()->findLoginInDatabase(); //проверка поля логин
        $this->passwordNoEmpty()->checkLengthPassword()->passwordEquality(); //проверка поля пароль
        $this->checkEmail(); //проверка поля e-mail
        $this->checkLengthName(); //проверка поля name
        $this->checkLengthSurname(); //проверка поля surname
        $this->checkPhone(); //проверка поля phone
    }

    // валидация для класса AdminModel, при редактирование данных администратором
    public function validationBeforeUpdateAdmin($id)  //adminCheckBeforeUpdate
    {
        $renameLogin = $this->getLogin($id) === $this->request['login'] ? false : true;  // нужна ли проверка на уникальность логина?
        $this->clearErrorBuffer(); // очищаем сессии от старых ошибок
        $this->loginNoEmpty()->checkLengthLogin(); //проверка поля логин
        if ($renameLogin) { //проверка нового логина на уникальность
            $this->findLoginInDatabase();
        }
        $this->checkEmail(); //проверка поля e-mail
        $this->checkLengthName(); //проверка поля name
        $this->checkLengthSurname(); //проверка поля surname
        $this->checkPhone(); //проверка поля phone
    }

    // валидация для класса IndexModel, при редактирование данных пользователем
    public function validationBeforeUpdateUser($id)
    {
        $renameLogin = $this->getLogin($id) === $this->request['login'] ? false : true;  // нужна ли проверка на уникальность логина?
        $this->clearErrorBuffer(); // очищаем сессии от старых ошибок
        $this->loginNoEmpty()->checkLengthLogin(); //проверка поля логин
        if ($renameLogin) { //проверка нового логина на уникальность
            $this->findLoginInDatabase();
        }
        if (!empty($this->request['password'])) {
            $this->checkLengthPassword(); //проверка поля пароль
        }
        $this->checkEmail(); //проверка поля e-mail
        $this->checkLengthName(); //проверка поля name
        $this->checkLengthSurname(); //проверка поля surname
        $this->checkPhone(); //проверка поля phone
    }

    private function loginNoEmpty()
    {
        if (empty($this->request['login'])) {
            $_SESSION['reg']['errors'][] = 'Не указан логин';
        }
        return $this;
    }

    private function checkLengthLogin()
    {
        $result = mb_strlen($this->request['login'], 'UTF-8') >= self::MIN_LENGTH_LOGIN;
        if (!$result) {
            $_SESSION['reg']['errors'][] = 'Слишком короткий логин';
        }
        return $this;
    }

    private function getLogin($id)
    {
        $sql = "SELECT login FROM clients WHERE id = ?";
        $category = [];
        $category[] = $id;
        $login = $this->connectDB->queryDB($sql, $category);
        return $login[0]['login'];
    }

    private function findLoginInDatabase()
    {
        $category = [];
        $sql = "SELECT login FROM clients WHERE login = ? LIMIT 1";
        $category[] = $this->request['login'];
        $foundLogin = $this->connectDB->queryDB($sql, $category);
        if (!empty($foundLogin)) {
            $_SESSION['reg']['errors'][] = 'Данный пользователь уже зарегистрирован в системе';
        }
        return $this;
    }

    private function passwordNoEmpty()
    {
        if (empty($this->request['password']) && empty($this->request['passwordReplay'])) {
            $_SESSION['reg']['errors'][] = 'Введите пароли';
        }
        return $this;
    }

    private function passwordEquality()
    {
        $equality = $this->request['password'] === $this->request['passwordReplay'];
        if (!$equality) {
            $_SESSION['reg']['errors'][] = 'Пароли не совпадают';
        }
        return $this;
    }

    private function checkLengthPassword()
    {
        $result = mb_strlen($this->request['password'], 'UTF-8') >= self::MIN_LENGTH_PASSWORD;
        if (!$result) {
            $_SESSION['reg']['errors'][] = 'Слишком короткий пароль';
        }
        return $this;
    }

    private function checkEmail()
    {
        if (empty($this->request['email'])) {
            $_SESSION['reg']['errors'][] = 'Не указан e-mail';
        }
    }

    private function checkLengthName()
    {
        if (!empty($this->request['name'])) {
            $result = mb_strlen($this->request['name'], 'UTF-8') >= self::MIN_LENGTH_NAME;
            if (!$result) {
                $_SESSION['reg']['errors'][] = 'Слишком короткое имя';
            }
        }
    }

    private function checkLengthSurname()
    {
        if (!empty($this->request['surname'])) {
            $result = mb_strlen($this->request['surname'], 'UTF-8') >= self::MIN_LENGTH_SURNAME;
            if (!$result) {
                $_SESSION['reg']['errors'][] = 'Слишком короткая фамилия';
            }
        }
    }

    private function checkPhone()
    {
        if (empty($this->request['phone'])) {
            $_SESSION['reg']['errors'][] = 'Не указан телефон';
        }
    }

    public function clearErrorBuffer()
    {
        unset($_SESSION['reg']['errors']);
    }
}