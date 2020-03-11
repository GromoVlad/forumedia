<?php

class IndexController implements IController
{
    public $path;

    public function __construct()
    {
        $config = new Config();
        $this->path = $config::APP_URL;
    }

    private function userAccessOnly()
    {
        if ($_SESSION['login']['isAdmin']) {
            header('Location: ' . $this->path . 'admin', true, 301);
        } elseif (empty($_SESSION['login']['user_login'])) {
            header('Location: ' . $this->path . 'registration', true, 301);
        } else {
            return true;
        }
    }

    public function indexAction()
    {
        session_start();
        if ($this->userAccessOnly()) {
            $fc = FrontController::getInstance();
            $model = new IndexModel();
            $output = $model->render(INDEX_PAGE);
            $fc->setBody($output);
        }
    }

    public function editAction()
    {
        session_start();
        if ($this->userAccessOnly()) {
            $fc = FrontController::getInstance();
            $model = new IndexModel();
            $output = $model->render(EDIT_USER_PAGE);
            $fc->setBody($output);
        }
    }

    public function updateAction()
    {
        session_start();
        if ($this->userAccessOnly()) {
            $fc = FrontController::getInstance();
            $model = new IndexModel();
            if ($model->updateUser()) {
                header('Location: ' . $this->path, true, 301);
            } else {
                $output = $model->render(EDIT_USER_PAGE);
                $fc->setBody($output);
            }
        }
    }

    public function destroyAction()
    {
        session_start();
        if ($this->userAccessOnly()) {
            $model = new IndexModel();
            $model->deleteUser();
            unset($_SESSION['login']);
            session_destroy();
            header('Location: ' . $this->path, true, 301);
        }
    }
}