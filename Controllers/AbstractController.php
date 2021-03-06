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

    // This is the constructor of the abstract controller
    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->database = DatabaseEngine::getConnection();
        $this->request = new RequestEngine();
        $this->errorHandler = new ErrorMessages();

        $this->generateUser();
        $this->assignErrorMessage();
        $this->generateContentForMenu();
        $this->generateProfileLink();
    }

    // This method adds an user to the session
    private function generateUser()
    {
        if ($this->request->SESSION("user") == "")
            $this->user = new User("");
        else
            $this->user = unserialize($this->request->SESSION("user"));

        $this->templateEngine->addVariable("usernameGreetingString", $this->user->getUsernameGreetingString());
        if($this->user->isLoggedIn())
        {
            $this->templateEngine->addVariable("userMail", $this->user->getEmail());
            $this->templateEngine->addVariable("userFirstName", $this->user->getFirstName());
            $this->templateEngine->addVariable("userLastName", $this->user->getLastName());
        }



    }

    // This method adds an error message to the template engine and shows it in the view
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

    // This method adds the user specific content to the template engine
    private function generateContentForMenu()
    {
        $this->templateEngine->addVariable("menuUserContent", User::getUserInteractionHtmlForMenu($this->user));
        $this->templateEngine->addVariable("menuUserProductContent", User::getUserProductInteractionHtmlForMenu($this->user));
    }

    // This method adds the profile link to the template engine
    private function generateProfileLink()
    {
        $this->templateEngine->addVariable("profileLink", User::getProfileLink($this->user));
    }

}