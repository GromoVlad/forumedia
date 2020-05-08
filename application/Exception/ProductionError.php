<?php

namespace Application\Exception;

use Config\Config;

class ProductionError extends ErrorHandler
{
    protected $errorMessage;
    protected $errorFile;
    protected $errorLine;
    public $appUrl;

    public function __construct($errorMessage)
    {
        $this->errorFile = $this->getFile();
        $this->errorLine = $this->getLine();
        $this->errorMessage = $errorMessage;
        $this->appUrl = Config::APP_URL;
        error_reporting(0);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    protected function displayError()
    {
        http_response_code(404);
        require NOT_FOUND_PAGE;
    }
}
