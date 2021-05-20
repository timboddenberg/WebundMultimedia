<?php

require_once __DIR__ . "\..\Engine\TemplateEngine.php";
require_once __DIR__ . "\..\Engine\DatabaseEngine.php";
require_once __DIR__ . "\..\Engine\RequestEngine.php";
require_once __DIR__ . "\..\Models\User.php";
require_once __DIR__ . "\..\Models\ErrorMessages.php";


class AbstractController
{
    protected TemplateEngine $templateEngine;

    protected mysqli $database;

    protected RequestEngine $request;

    protected User $user;

    protected ErrorMessages $errorHandler;

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->database = DatabaseEngine::getConnection();
        $this->request = new RequestEngine();
        $this->errorHandler = new ErrorMessages();

        $this->generateUser();
        $this->assignErrorMessage();
    }

    private function generateUser()
    {
        if ($this->request->SESSION("user") == "")
            $this->user = new User("");
        else
            $this->user = unserialize($this->request->SESSION("user"));

        $this->templateEngine->addVariable("usernameGreetingString", $this->user->getUsernameGreetingString());
    }

    private function assignErrorMessage()
    {
        $errorMessageHtml = "";
        if ($this->errorHandler->errorOccurred())
        {
            $errorMessageHtml = "
            <div class='alert alert-danger errorMessage' role='alert'>" .
                $this->errorHandler->getErrorMessage() .
            "</div>";
        }

        $this->templateEngine->addVariable("errorMessage",$errorMessageHtml);
        $this->errorHandler->unsetMessages();
    }

}