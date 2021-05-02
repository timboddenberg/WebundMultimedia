<?php

class User
{
    private string $mail;
    private string $name;
    private int $userID;

    public function __construct(string $email)
    {
        $this->mail = $email;
        $this->name = explode("@", $email)[0];
    }

    public function setUserID(int $id)
    {
        $this->userID = $id;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getUsernameGreetingString()
    {
        if ($this->mail == "")
            return "";
        else
            return "Hallo, " . $this->name;
    }

    public function getEmail()
    {
        return $this->mail;
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
}