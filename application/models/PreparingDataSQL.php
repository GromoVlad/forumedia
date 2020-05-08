<?php

namespace Application\Models;

use Config\Config;
use PDO;

class PreparingDataSQL
{
    const MAX_WIDTH_PHOTO = 900; //px
    private $header;
    private $request;
    private $file;
    private $defaultValueActivation;
    private $defaultValueClub;

    public function __construct($request, $file)
    {
        $this->header = new HeaderModel;
        $this->request = $request;
        $this->file = $file;
        $this->defaultValueActivation = Config::DEFAULT_VALUE_ACTIVATION;
        $this->defaultValueClub = Config::DEFAULT_VALUE_CLUB;
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

    // подготовка данных перед созданием пользователя
    public function generateDataBeforeCreating()
    {
        $category = [];
        $category[] = $this->request['login'];
        $category[] = md5($this->request['password']);
        $category[] = $this->request['email'];
        $category[] = $this->getName();
        $category[] = $this->getSurname();
        $category[] = $this->request['phone'];
        $category[] = $this->checkPhoto();
        $category[] = $this->getAddress();
        $category[] = $this->getCurrentTime();
        $category[] = $this->getCurrentTime();
        $category[] = isset($this->request['active']) ? $this->request['active'] : $this->defaultValueActivation;
        $category[] = empty($this->request['club_type']) ? $this->defaultValueClub : $this->request['club_type'];
        return $category;
    }

    // подготовка данных класса AdminModel, реализует редактирование полей
    public function generateDataBeforeUpdatingAdmin($id) 
    {
        $category = [];
        $category[] = $this->request['login'];
        $category[] = $this->request['email'];
        $category[] = $this->getName();
        $category[] = $this->getSurname();
        $category[] = $this->request['phone'];
        if (!empty($this->file['photo']['tmp_name'])) {
            $category[] = $this->checkPhoto();
        } else {
            $category[] = $this->getPhoto($id);
        }
        $category[] = $this->getAddress();
        $category[] = $this->getCurrentTime();
        $category[] = $this->request['active'];
        $category[] = $this->request['club_type'];
        $category[] = $id;
        return $category;
    }

    public function generateDataBeforeUpdatingUser($id)
    {
        $category = [];
        $category[] = $this->request['login'];
        if (!empty($_POST['password'])) {
            $category[] = md5($this->request['password']);
        }
        $category[] = $this->request['email'];
        $category[] = $this->getName();
        $category[] = $this->getSurname();
        $category[] = $this->request['phone'];
        if (!empty($this->file['photo']['tmp_name'])) {
            $category[] = $this->checkPhoto();
        } else {
            $category[] = $this->getPhoto($id);
        }
        $category[] = $this->getAddress();
        $category[] = $this->getCurrentTime();
        $category[] = $id;
        return $category;
    }

    private function getName()
    {
        if (empty($this->request['name'])) {
            return null;
        } else {
            return $this->request['name'];
        }
    }

    private function getSurname()
    {
        if (empty($this->request['surname'])) {
            return null;
        } else {
            return $this->request['surname'];
        }
    }

    private function checkPhoto()
    {
        if ($this->savePhoto()[0]) {
            return $this->savePhoto()[1];
        } else {
            return 'unknown.png';
        }
    }

    private function savePhoto()
    {
        if (!empty($this->file['photo']['tmp_name'])) {
            $tmp_name = $this->file['photo']['tmp_name'];
            $name = basename($this->file['photo']['tmp_name']);
            $uploads_dir = 'data/images/' . $name;
            $isLoaded = move_uploaded_file($tmp_name, $uploads_dir);
            $this->makeAvatar($name);
            $this->resizePhoto($name);
            return [$isLoaded, $name];
        }
    }

    private function resizePhoto($name)
    {
        $params = getimagesize('data/images/' . $name);
        $widthPhoto = $params[0];
        if ($widthPhoto > self::MAX_WIDTH_PHOTO) {
            $image = new ImageModel();
            $image->load('data/images/' . $name);
            $image->resizeToWidth(self::MAX_WIDTH_PHOTO);
            $image->save('data/images/' . $name);
        }
    }

    private function makeAvatar($name)
    {
        $avatar = new ImageModel();
        $avatar->load('data/images/' . $name);
        $avatar->resizeToWidth(100);
        $avatar->save('data/images/avatar/' . $name);
    }

    private function getAddress()
    {
        if (empty($this->request['address'])) {
            return null;
        } else {
            return $this->request['address'];
        }
    }

    private function getCurrentTime()
    {
        $currentTime = date_create();
        $formatCurrentTime = $currentTime->format('Y-m-d H:i:s');
        return $formatCurrentTime;
    }

    private function getPhoto($id)
    {
        $sql = "SELECT image FROM clients WHERE id = ?";
        $category = [];
        $category[] = $id;
        $image = $this->queryDB($sql, $category);
        return $image[0]['image'];
    }
}