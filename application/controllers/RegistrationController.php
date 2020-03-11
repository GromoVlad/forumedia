<?php

class RegistrationController implements IController
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
        $model = new RegistrationModel();
        $output = $model->render(REG_PAGE);
        $fc->setBody($output);
    }

    public function createAction()
    {
        session_start();
        $fc = FrontController::getInstance();
        $model = new RegistrationModel($_POST, $_FILES);
        if ($model->createUser()) {
            header('Refresh: 5; url=' . $this->path . 'login/');
            $output = $model->render(REG_SUCCESSFUL_PAGE);
            $fc->setBody($output);
        } else {
            $output = $model->render(REG_PAGE);
            $fc->setBody($output);
        }
    }
}
