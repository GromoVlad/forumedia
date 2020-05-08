<?php

namespace Application\Models;

use PDO;

class Validator
{
    const MIN_LENGTH_LOGIN = 5;
    const MIN_LENGTH_PASSWORD = 6;
    const MIN_LENGTH_NAME = 3;
    const MIN_LENGTH_SURNAME = 3;
    private $request;

    public function __construct($request)
    {
        $this->clearErrorBuffer();
        $this->request = $request;
    }

    public function validationBeforeCreation() // валидация всех полей при регистрации нового пользователя
    {
        $this->clearErrorBuffer()->loginNoEmpty()->checkLengthLogin()->findLoginInDatabase()->passwordNoEmpty()
            ->checkLengthPassword()->passwordEquality()->checkEmail()->checkLengthName()->checkLengthSurname()
            ->checkPhone();
    }

    public function validationBeforeUpdateAdmin($id) // валидация в классу AdminModel, при редакт-нии данных админом
    {
        $this->clearErrorBuffer()->loginNoEmpty()->checkLengthLogin()->checkEmail()->checkLengthName()
            ->checkLengthSurname()->checkPhone();
        if ($this->getLogin($id) !== $this->request['login']) { //проверка нового логина на уникальность
            $this->findLoginInDatabase();
        }
    }

    public function validationBeforeUpdateUser($id) // валидация в классе IndexModel, при редакт-нии данных юзером
    {
        $this->clearErrorBuffer()->loginNoEmpty()->checkLengthLogin()->checkEmail()->checkLengthName()
            ->checkLengthSurname()->checkPhone();
        if ($this->getLogin($id) !== $this->request['login']) { //проверка нового логина на уникальность
            $this->findLoginInDatabase();
        }
        if (!empty($this->request['password'])) {
            $this->checkLengthPassword(); //проверка поля пароль
        }
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
        $login = $this->queryDB($sql, $category);
        return $login[0]['login'];
    }

    private function findLoginInDatabase()
    {
        $category = [];
        $sql = "SELECT login FROM clients WHERE login = ? LIMIT 1";
        $category[] = $this->request['login'];
        /* Не понимаю почему перестал работать $foundLogin = $this->connectDB->queryDB($sql, $category);, заменил на код из DBModel */
        $foundLogin = $this->queryDB($sql, $category);
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
        return $this;
    }

    private function checkLengthName()
    {
        if (!empty($this->request['name'])) {
            $result = mb_strlen($this->request['name'], 'UTF-8') >= self::MIN_LENGTH_NAME;
            if (!$result) {
                $_SESSION['reg']['errors'][] = 'Слишком короткое имя';
            }
        }
        return $this;
    }

    private function checkLengthSurname()
    {
        if (!empty($this->request['surname'])) {
            $result = mb_strlen($this->request['surname'], 'UTF-8') >= self::MIN_LENGTH_SURNAME;
            if (!$result) {
                $_SESSION['reg']['errors'][] = 'Слишком короткая фамилия';
            }
        }
        return $this;
    }

    private function checkPhone()
    {
        if (empty($this->request['phone'])) {
            $_SESSION['reg']['errors'][] = 'Не указан телефон';
        }
        return $this;
    }

    public function clearErrorBuffer()
    {
        unset($_SESSION['reg']['errors']);
        return $this;
    }

    private function queryDB($sql, $category = false)
    {
        $stmt = DBModel::getInstance()->prepare($sql);
        if (!$category) {
            $stmt->execute();
        } else {
            $stmt->execute($category);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}