<?php

class LoginController implements IController
{
    public $path;

    public function __construct()
    {
        $config = new Config();
        $this->path = $config::APP_URL;
    }

    public function indexAction()
    {
        session_start();
        $fc = FrontController::getInstance();
        $model = new LoginModel();
        if (!empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path, true, 301);
        } else {
            $output = $model->render(LOGIN_PAGE);
            $fc->setBody($output);
        }
    }

    public function entryAction()
    {
        session_start();
        $fc = FrontController::getInstance();
        $model = new LoginModel();
        $model->verificationLogin($_POST);
        if (!empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path, true, 301);
        } else {
            $output = $model->render(LOGIN_PAGE);
            $fc->setBody($output);
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