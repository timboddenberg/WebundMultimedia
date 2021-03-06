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

    // This method returns the users category, Admin or User
    public function getUserCategory(): string
    {
        return $this->isAdmin() ? "Administrator" : "Benutzer";
    }

    // This method encrypts the password with a hash algorithm
    public static function EncryptPassword(string $password)
    {
        $salt1 = "qm&h*";
        $salt2 = "pg!@";

        return hash('ripemd128', "$salt1$password$salt2");
    }

    // This method checks if the password is correct
    public static function CheckPassword(string $formPassword, string $password)
    {
        $salt1 = "qm&h*";
        $salt2 = "pg!@";

        $formPassword = hash('ripemd128', "$salt1$formPassword$salt2");
        return $formPassword == trim($password);
    }

    // This method generates the HTML code for the admin specific menu
    public static function getUserInteractionHtmlForMenu(User $user)
    {
        $html = "";

        if ($user->isAdmin())
        {
            $html = $html . "<div><a href='/WebundMultimedia/product/administration' class='listButton'>Produktadministration</a></div>";
            $html = $html . "<div><a href='/WebundMultimedia/user/administration' class='listButton'>Benutzeradministration</a></div>";
            $html = $html . "<div><a href='/WebundMultimedia/activity/display' class='listButton'>Aktivit??ts Log</a></div>";
        }

        if ($user->isLoggedIn())
        {
            $html = $html . "<div><a href='/WebundMultimedia/user/edit' class='listButton'>Account verwalten</a></div>";
            $html = $html . "<div><a href='/WebundMultimedia/user/logout/performLogout' class='listButton'>Ausloggen</a></div>";
        }

        return $html;
    }

    // This method generates the HTML code for the user specific menu
    public static function getUserProductInteractionHtmlForMenu(User $user)
    {
        $html = "";

        if ($user->isLoggedIn())
        {
            $html = $html . "<div><a class='listButton' href='/WebundMultimedia/shoppingcart'>Warenkorb</a></div>";
            $html = $html . "<div><a class='listButton' href='/WebundMultimedia/ratedProducts'>Meine Bewertungen</a></div>";
            $html = $html . "<div><a class='listButton' href='/WebundMultimedia/orders'>Meine Bestellungen</a></div>";
        }

        return $html;
    }

    // This method checks if the user is logged in and returns an error message if not
    public static function validateUserRequest(User $user)
    {
        $errorMessage = new ErrorMessages();

        if ( ! $user->isLoggedIn())
        {
            $errorMessage->setErrorMessage("Bitte loggen Sie sich f??r diese Aktion ein.");
            header("Location: http://Localhost/WebundMultimedia/");
            die();
        }
    }

    // This method checks whether the user has got admin rights and returns an error message if not
    public static function validateAdminRequest(User $user)
    {
        $errorMessage = new ErrorMessages();

        if ( ! $user->isAdmin())
        {
            $errorMessage->setErrorMessage("Sie ben??tigen Admin Rechte f??r diese Aktion.");
            header("Location: http://Localhost/WebundMultimedia/");
        }
    }

    // This method generates the profile link if the user is logged in or not
    public static function getProfileLink(User $user)
    {
        if ( ! $user->isLoggedIn())
        {
            $profileLink =
                "/WebundMultimedia/user/login";
        }
        else
        {
            $profileLink =
                "/WebundMultimedia/user/edit";
        }
        return $profileLink;
    }

}