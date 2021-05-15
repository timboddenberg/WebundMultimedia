<?php

require_once __DIR__ . "\..\Engine\RequestEngine.php";

class ErrorMessages
{
    private string $errorMessage;
    private RequestEngine $requestEngine;
    private ErrorMessages $errorHandlerSession;

    public function __construct()
    {
        $this->requestEngine = new RequestEngine();
        $errorHandlerSession = $this->requestEngine->SESSION("errorHandler");

        if (!$errorHandlerSession == "")
        {
            $this->errorHandlerSession = unserialize($errorHandlerSession);

            if ($this->errorHandlerSession->getErrorMessage())
                $this->errorMessage = $this->errorHandlerSession->getErrorMessage();
        }

    }

    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        $this->requestEngine->setSESSION("errorHandler",serialize($this));
    }

    public function errorOccurred(): bool
    {
        return ! empty($this->errorMessage);
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function unsetMessages()
    {
        $this->errorMessage = "";
        $this->requestEngine->setSESSION("errorHandler",serialize($this));
    }
}