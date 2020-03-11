<?php

class HeaderModel
{
    public $path;
    public $string;

    public function __construct()
    {
        $config = new Config();
        $this->path = $config::APP_URL;
    }

    public function getMenu()
    {
        if (!empty($_SESSION['login']['user_login']) && $_SESSION['login']['isAdmin']) {
            echo $this->adminMenu();
        } elseif (!empty($_SESSION['login']['user_login']) && !$_SESSION['login']['isAdmin']) {
            echo $this->userMenu();
        } else {
            echo $this->guestMenu();
        }
    }

    private function adminMenu()
    {
        $this->string  = '<div class="nav_one"><a href="' . $this->path . '">Главная</a></div>';
        $this->string .= '<div class="nav_two"><a href="' . $this->path . 'admin">Панель администратора</div>';
        $this->string .= '<div class="nav_three"><a href="' . $this->path . 'registration">Регистрация</a></div>';
        $this->string .= '<div class="nav_four"><a href="' . $this->path . 'login/logout">Выйти</a></div>';
        return $this->string;
    }

    private function userMenu()
    {
        $this->string  = '<div class="nav_first"><a href="' . $this->path . '">Главная</a></div>';
        $this->string .= '<div class="nav_two">Добро пожаловать, ' . ucfirst($_SESSION['login']['user_login']) . '!</div>';
        $this->string .= '<div class="nav_center"><a href="' . $this->path . 'registration">Регистрация</a></div>';
        $this->string .= '<div class="nav_four"><a href="' . $this->path . 'login/logout">Выйти</a></div>';
        return $this->string;
    }

    private function guestMenu()
    {
        $this->string  = ' <div class="nav_first"><a href="' . $this->path . '">Главная</a></div>';
        $this->string .= '<div class="nav_center"></div>';
        $this->string .= '<div class="nav_center"><a href="' . $this->path . 'registration">Регистрация</a></div>';
        $this->string .= '<div class="nav_last"><a data-toggle="modal" data-target="#exampleModal">Войти</a></div>';
        return $this->string;
    }
}