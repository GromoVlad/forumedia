<?php

namespace Application\Controllers;

use Application\Models\AdminModel;
use Config\Config;

class AdminController implements IController
{
    public $path;
    private $fc;
    private $model;

    public function __construct()
    {
        $this->path = Config::APP_URL;
        $this->fc = FrontController::getInstance();
        $this->model = new AdminModel();
    }

    public function indexAction()
    {
        session_start();
        $this->isAdmin();
        $this->model->params = $this->fc->getParams();
        $output = $this->model->render(ADMIN_PAGE);
        $this->fc->setBody($output);
        $this->model->clearErrorBuffer();
    }

    public function showAction()
    {
        session_start();
        $this->isAdmin();
        $this->model->params = $this->fc->getParams();
        $output = $this->model->render(SHOW_USER_PAGE);
        $this->fc->setBody($output);
    }

    public function editAction()
    {
        session_start();
        $this->isAdmin();
        $this->model->params = $this->fc->getParams();
        $output = $this->model->render(ADMIN_EDIT_USER_PAGE);
        $this->fc->setBody($output);
    }

    public function updateAction()
    {
        session_start();
        $this->isAdmin();
        $this->model->params = $this->fc->getParams();
        if ($this->model->updateUser()) {
            header('Location: ' . $this->path . 'admin', true, 301);
        } else {
            $output = $this->model->render(ADMIN_EDIT_USER_PAGE);
            $this->fc->setBody($output);
        }
    }

    public function destroyAction()
    {
        session_start();
        $this->isAdmin();
        $this->model->params = $this->fc->getParams();
        $this->model->deleteUser();
        header('Location: ' . $this->path . 'admin', true, 301);
    }

    public function createAction()
    {
        session_start();
        $this->isAdmin();
        if ($this->model->createUser()) {
            header('Refresh: 5; url=' . $this->path . 'admin/');
            $output = $this->model->render(REG_SUCCESSFUL_PAGE);
            $this->fc->setBody($output);
        } else {
            header('Location: ' . $this->path . 'admin', true, 301);
        }
    }

    private function isAdmin()
    {
        if (!isset($_SESSION['login']['isAdmin']) && !$_SESSION['login']['isAdmin']) {
            header('Location: ' . $this->path, true, 301);
        }
    }
}