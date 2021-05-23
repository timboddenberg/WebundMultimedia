<?php

require_once __DIR__ . "\..\Models\ErrorMessages.php";

class User
{
    private string $mail;
    private string $name;
    private string $firstname;
    private int $userID;
    private bool $loggedIn = false;
    private bool $isAdmin = false;

    public function __construct(string $email)
    {
        $this->mail = $email;
        $this->firstname = "";

        if ($this->mail != "")
            $this->loggedIn = true;
    }

    public function setUserID(int $id)
    {
        $this->userID = $id;
    }
    public function setFirstName(String $fname)
    {
        $this->firstname = $fname;
    }
    public function setLastName(String $lname)
    {
        $this->name = $lname;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getUsernameGreetingString()
    {
        if ($this->firstname == "")
            return "";
        else
            return "Hallo, " . $this->firstname;
    }

    public function getEmail()
    {
        return $this->mail;
    }

    public function isLoggedIn()
    {
        return $this->loggedIn;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public static function EncryptPassword(string $password)
    {
        $salt1 = "qm&h*";
        $salt2 = "pg!@";

        return hash('ripemd128', "$salt1$password$salt2");
    }

    public static function CheckPassword(string $formPassword, string $password)
    {
        $salt1 = "qm&h*";
        $salt2 = "pg!@";

        $formPassword = hash('ripemd128', "$salt1$formPassword$salt2");
        return $formPassword == trim($password);
    }

    public static function getUserInteractionHtmlForMenu(User $user)
    {
        $html = "";

        if ($user->isAdmin())
        {
            $html = $html . "<div class='listButton'><a href='/WebundMultimedia/product/administration' class='btn btn-secondary btn-lg active'>Produktadministration</a></div>";
        }

        if ($user->isLoggedIn())
        {
            $html = $html . "<div class='listButton'><a href='/WebundMultimedia/user/remove' class='btn btn-secondary btn-lg active'>Account verwalten</a></div>";
            $html = $html . "<div class='listButton'><a href='/WebundMultimedia/user/logout/performLogout' class='btn btn-secondary btn-lg active'>Ausloggen</a></div>";
        }

        return $html;
    }

    public static function validateUserRequest(User $user)
    {
        $errorMessage = new ErrorMessages();

        if ( ! $user->isLoggedIn())
        {
            $errorMessage->setErrorMessage("Bitte loggen Sie sich für diese Aktion ein.");
            header("Location: http://Localhost/WebundMultimedia/");
        }
    }

    public static function validateAdminRequest(User $user)
    {
        $errorMessage = new ErrorMessages();

        if ( ! $user->isAdmin())
        {
            $errorMessage->setErrorMessage("Sie benötigen Admin Rechte für diese Aktion.");
            header("Location: http://Localhost/WebundMultimedia/");
        }
    }
}