<?php

use Application\Controllers\FrontController;

/* Подключаем автозагрузчик */
require_once __DIR__ . '/vendor/autoload.php';

/* Имена файлов: views */
define('INDEX_PAGE', __DIR__ . '\Application\Views\title.php');
define('TWO_PAGE', __DIR__ . '\Application\Views\two.php');
define('NOT_FOUND_PAGE', __DIR__ . '\Application\Views\ErrorViews\404.php');
define('DEVELOP_PAGE', __DIR__ . '\Application\Views\ErrorViews\develop.php');
define('LOGIN_PAGE', __DIR__ . '\Application\Views\login.php');
define('REG_PAGE', __DIR__ . '\Application\Views\registration.php');
define('REG_SUCCESSFUL_PAGE', __DIR__ . '\Application\Views\successful_registration.php');
define('ADMIN_PAGE', __DIR__ . '\Application\Views\admin.php');
define('SHOW_USER_PAGE', __DIR__ . '\Application\Views\show_user.php');
define('ADMIN_EDIT_USER_PAGE', __DIR__ . '\Application\Views\edit_admin.php');
define('EDIT_USER_PAGE', __DIR__ . '\Application\Views\edit_user.php');

/* Инициализация и запуск FrontController */
$front = FrontController::getInstance();
$front->route();

/* Вывод данных */
echo $front->getBody();