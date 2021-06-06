<?php

require_once __DIR__ . "\..\Models\ErrorMessages.php";

class User
{
    private string $mail;
    private string $lastName;
    private string $firstname;
    private int $userId;
    private bool $loggedIn = false;
    private bool $isAdmin = false;

    public function __construct(string $email)
    {
        $this->mail = $email;
        $this->firstname = "";

        if ($this->mail != "")
            $this->loggedIn = true;
    }

    public function setUserId(int $id)
    {
        $this->userId = $id;
    }

    public function setFirstName(String $firstName)
    {
        $this->firstname = $firstName;
    }

    public function setLastName(String $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getLastName()
    {
        return $this->lastName;
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

    public function getUserCategory(): string
    {
        return $this->isAdmin() ? "Administrator" : "Benutzer";
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
            $html = $html . "<div><a href='/WebundMultimedia/product/administration' class='listButton'>Produktadministration</a></div>";
            $html = $html . "<div><a href='/WebundMultimedia/user/administration' class='listButton'>Benutzeradministration</a></div>";

        }

        if ($user->isLoggedIn())
        {
            $html = $html . "<div><a href='/WebundMultimedia/user/remove' class='listButton'>Account verwalten</a></div>";
            $html = $html . "<div><a href='/WebundMultimedia/user/logout/performLogout' class='listButton'>Ausloggen</a></div>";
        }

        return $html;
    }

    public static function getUserProductInteractionHtmlForMenu(User $user)
    {
        $html = "";

        if ($user->isLoggedIn())
        {
            $html = $html . "<div><a class='listButton' href='/WebundMultimedia/shoppingcart'>Warenkorb</a></div>";
            $html = $html . "<div><a class='listButton' href='/WebundMultimedia/ratedProducts'>Meine Bewertungen</a></div>";
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
            die();
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