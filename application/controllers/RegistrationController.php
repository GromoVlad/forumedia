<?php

namespace Application\Controllers;

use Application\Models\RegistrationModel;
use Config\Config;

class RegistrationController implements IController
{
    public $path;
    private $model;
    private $fc;

    public function __construct()
    {
        $this->path = Config::APP_URL;
        $this->fc = FrontController::getInstance();
        $this->model = new RegistrationModel($_POST, $_FILES);
    }

    public function indexAction()
    {
        session_start();
        $output = $this->model->render(REG_PAGE);
        $this->fc->setBody($output);
    }

    public function createAction()
    {
        session_start();
        if ($this->model->createUser()) {
            header('Refresh: 5; url=' . $this->path . 'login/');
            $output = $this->model->render(REG_SUCCESSFUL_PAGE);
            $this->fc->setBody($output);
        } else {
            $output = $this->model->render(REG_PAGE);
            $this->fc->setBody($output);
        }
    }
}
