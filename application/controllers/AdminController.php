<?php

class AdminController implements IController
{
    public $path;

    public function __construct()
    {
        $config = new Config();
        $this->path = $config::APP_URL;
    }

    private function isAdmin()
    {
        if (isset($_SESSION['login']['isAdmin']) && $_SESSION['login']['isAdmin']) {
            return true;
        } else {
            header('Location: ' . $this->path, true, 301);
        }
    }

    public function indexAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            $model->params = $fc->getParams();
            $output = $model->render(ADMIN_PAGE);
            $fc->setBody($output);
            $model->clearErrorBuffer();
        }
    }

    public function showAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            $model->params = $fc->getParams();
            $output = $model->render(SHOW_USER_PAGE);
            $fc->setBody($output);
        }
    }

    public function editAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            $model->params = $fc->getParams();
            $output = $model->render(ADMIN_EDIT_USER_PAGE);
            $fc->setBody($output);
        }
    }

    public function updateAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            $model->params = $fc->getParams();
            if ($model->updateUser()) {
                header('Location: ' . $this->path . 'admin', true, 301);
            } else {
                $output = $model->render(ADMIN_EDIT_USER_PAGE);
                $fc->setBody($output);
            }
        }
    }

    public function destroyAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            $model->params = $fc->getParams();
            $model->deleteUser();
            header('Location: ' . $this->path . 'admin', true, 301);
        }
    }

    public function createAction()
    {
        session_start();
        if ($this->isAdmin()) {
            $fc = FrontController::getInstance();
            $model = new AdminModel();
            if ($model->createUser()) {
                header('Refresh: 5; url=' . $this->path . 'admin/');
                $output = $model->render(REG_SUCCESSFUL_PAGE);
                $fc->setBody($output);
            } else {
                header('Location: ' . $this->path . 'admin', true, 301);
            }
        }
    }
}