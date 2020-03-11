<?php
/* Пути по-умолчанию для поиска файлов */
set_include_path(get_include_path() . PATH_SEPARATOR . 'application/controllers' .
                PATH_SEPARATOR . 'application/models' . PATH_SEPARATOR . 'application/views' .
                PATH_SEPARATOR . 'config' . PATH_SEPARATOR . 'data/mailer');

/* Имена файлов: views */
const INDEX_PAGE = 'title.php';
const LOGIN_PAGE = 'login.php';
const REG_PAGE = 'registration.php';
const REG_SUCCESSFUL_PAGE = 'successful_registration.php';
const ADMIN_PAGE = 'admin.php';
const SHOW_USER_PAGE = 'show_user.php';
const ADMIN_EDIT_USER_PAGE = 'edit_admin.php';
const EDIT_USER_PAGE = 'edit_user.php';

/* Автозагрузчик классов */
spl_autoload_register(function ($class) {
    require_once($class . '.php');
});

/* Инициализация и запуск FrontController */
$front = FrontController::getInstance();
$front->route();

/* Вывод данных */
echo $front->getBody();