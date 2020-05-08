<?php

namespace Application\Exception;

class DevelopError extends ErrorHandler
{
    protected $errorMessage;
    protected $errorFile;
    protected $errorLine;

    public function __construct($errorMessage)
    {
        $this->errorFile = $this->getFile();
        $this->errorLine = $this->getLine();
        $this->errorMessage = $errorMessage;
        error_reporting(-1);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    protected function displayError()
    {
        require DEVELOP_PAGE;
    }
}
