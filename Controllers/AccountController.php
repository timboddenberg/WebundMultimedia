<?php

require_once __DIR__ . "\AbstractController.php";

class AccountController extends AbstractController
{
    public function loadCreator()
    {
        if (array_key_exists("accountCreated",$_GET) && $_GET["accountCreated"] == "false")
            $this->templateEngine->addVariable("accountCreated","doppelter Benutzername");
        elseif (array_key_exists("accountCreated",$_GET) && $_GET["accountCreated"] == "true")
            $this->templateEngine->addVariable("accountCreated","Account erfolgreich angelegt");
        else
            $this->templateEngine->addVariable("accountCreated","");

        $this->templateEngine->display("\Account\Registration.tpl");
    }

    public function create()
    {
        if (!$this->validateAccountCreation())
        {
            header("Location: http://Localhost/WebundMultimedia/create?accountCreated=false");
            die;
        }

        $salt1 = "qm&h*";
        $salt2 = "pg!@";

        $user = $_POST["username"];
        $password = $_POST["password"];
        $token = hash('ripemd128', "$salt1$password$salt2");

        $query = "INSERT INTO benutzer VALUES('','$user', '$token')";
        $this->database->query($query);
        header("Location: http://Localhost/WebundMultimedia/create?accountCreated=true");
        die;
    }

    private function validateAccountCreation()
    {
        $query = "SELECT * FROM benutzer WHERE Benutzername = '" . $_POST["username"] . "'";
        $result = $this->database->query($query);
        if ($result->num_rows > 0) {
           return false;
        }
        else
            {
                return true;
            }
    }
}