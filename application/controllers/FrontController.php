<?php

namespace Application\Controllers;

use Application\Exception\ErrorHandler;
use Exception;
use ReflectionClass;

class FrontController
{
    protected $controller, $action, $params, $body;
    static $instance;

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $request = $_SERVER['REQUEST_URI'];
        $splits = explode('/', trim($request, '/'));
        //Какой сontroller использовать?
        $this->controller = !empty($splits[0]) ? 'Application\\Controllers\\' . ucfirst($splits[0]) . 'Controller' : 'Application\\Controllers\\IndexController';
        //Какой action использовать?
        $this->action = !empty($splits[1]) ? $splits[1] . 'Action' : 'indexAction';
        if (!empty($splits[2])) { //Есть ли параметры и их значения?
            $keys = $values = [];
            for ($i = 2, $cnt = count($splits); $i < $cnt; $i++) {
                if ($i % 2 == 0) { //Чётное = ключ (параметр)
                    $keys[] = $splits[$i];
                } else {  //Значение параметра
                    $values[] = $splits[$i];
                }
            }
            @$this->params = array_combine($keys, $values);
        }
    }

    public function route()
    {
        if (class_exists($this->getController())) {
            $rc = new ReflectionClass($this->getController());
            if ($rc->implementsInterface('Application\\Controllers\\IController')) {
                if ($rc->hasMethod($this->getAction())) {
                    $controller = $rc->newInstance();
                    $method = $rc->getMethod($this->getAction());
                    $method->invoke($controller);
                } else {
                    throw ErrorHandler::delegate('У контроллера <b>"' . $this->getController() . '"</b> нет метода <b>"' . $this->getAction() . '"</b>');
                }
            } else {
                throw ErrorHandler::delegate('Контроллер <b>"' . $this->getController() . '"</b> не реализует интерфейс IController');
            }
        } else {
            throw ErrorHandler::delegate('Простанства имен <b>"' . $this->getController() . '"</b> не существует среди контроллеров');
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }
}