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

    // This method adds a new error message to the session
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        $this->requestEngine->setSESSION("errorHandler",serialize($this));
    }

    // This method returns a bool value if the error message is empty or not
    public function errorOccurred(): bool
    {
        return ! empty($this->errorMessage);
    }

    // This method returns the error message as a string
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    // This method removes the error message from the session
    public function unsetMessages()
    {
        $this->errorMessage = "";
        $this->requestEngine->setSESSION("errorHandler",serialize($this));
    }
}