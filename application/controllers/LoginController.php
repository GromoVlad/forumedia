<?php

namespace Application\Controllers;

use Application\Models\LoginModel;
use Config\Config;

class LoginController implements IController
{
    public $path;
    private $model;
    private $fc;

    public function __construct()
    {
        $this->path = Config::APP_URL;
        $this->fc = FrontController::getInstance();
        $this->model = new LoginModel();
    }

    public function indexAction()
    {
        session_start();
        if (!empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path, true, 301);
        } else {
            $output = $this->model->render(LOGIN_PAGE);
            $this->fc->setBody($output);
        }
    }

    public function entryAction()
    {
        session_start();
        $this->model->verificationLogin($_POST);
        if (!empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path, true, 301);
        } else {
            $output = $this->model->render(LOGIN_PAGE);
            $this->fc->setBody($output);
        }
    }

    public function logoutAction()
    {
        session_start();
        unset($_SESSION['login']);
        session_destroy();
        header('Location: ' . $this->path, true, 301);
    }
}