<?php

namespace Application\Exception;

use Config\Config;
use Exception;

class ErrorHandler extends Exception
{
    public static function delegate($errorMessage)
    {
        if (Config::DEBUG_MODE){
            return new DevelopError($errorMessage);
        } else{
            return new ProductionError($errorMessage);
        }
    }

    public function exceptionHandler()
    {
        $this->logErrors();
        $this->displayError();
    }

    protected function logErrors()
    {
        error_log("[" . date('Y-m-d H:i:s') . "] \n Текст ошибки: \n $this->errorMessage \n Файл: $this->errorFile \n Строка: $this->errorLine \n ================== \n",
            3, dirname(__DIR__, 2) . '/tmp/errors.log');
    }
}
