<?php

namespace Application\Controllers;

use Application\Models\IndexModel;
use Config\Config;

class IndexController implements IController
{
    public $path;
    private $fc;
    private $model;

    public function __construct()
    {
        $this->path = Config::APP_URL;
        $this->fc = FrontController::getInstance();
        $this->model = new IndexModel();
    }

    public function indexAction()
    {
        session_start();
        $this->userAccessOnly();
        $output = $this->model->render(INDEX_PAGE);
        $this->fc->setBody($output);
    }

    public function editAction()
    {
        session_start();
        $this->userAccessOnly();
        $output = $this->model->render(EDIT_USER_PAGE);
        $this->fc->setBody($output);
    }

    public function updateAction()
    {
        session_start();
        $this->userAccessOnly();
        if ($this->model->updateUser()) {
            header('Location: ' . $this->path, true, 301);
        } else {
            $output = $this->model->render(EDIT_USER_PAGE);
            $this->fc->setBody($output);
        }
    }

    public function destroyAction()
    {
        session_start();
        $this->userAccessOnly();
        $this->model->deleteUser();
        unset($_SESSION['login']);
        session_destroy();
        header('Location: ' . $this->path, true, 301);
    }

    private function userAccessOnly()
    {
        if ($_SESSION['login']['isAdmin']) {
            header('Location: ' . $this->path . 'admin', true, 301);
        } elseif (empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path . 'registration', true, 301);
        }
    }
}