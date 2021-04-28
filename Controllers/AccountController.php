<?php
session_start();

require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\User.php";

class AccountController extends AbstractController
{
    public function displayLogin()
    {
        if ($this->errorHandler->errorOccurred())
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
        else
            $this->templateEngine->addVariable("accountErrorMessage","");

        $this->templateEngine->display("\Account\Login.tpl");
    }

    public function displayRegister()
    {
        if ($this->errorHandler->errorOccurred())
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
        else
            $this->templateEngine->addVariable("accountErrorMessage","");

        $this->templateEngine->display("\Account\Registration.tpl");
    }

    public function performLogin()
    {
        $query = "SELECT * FROM benutzer WHERE Benutzername = '" . $_POST["username"] . "'";
        $result = $this->database->query($query);

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_row();

            if (User::CheckPassword($this->request->POST("password"),$row[2]))
            {
                $user = new User($row[1]);
                $user->setUserID($row[0]);

                $this->request->setSESSION("user",serialize($user));

                $this->errorHandler->setErrorMessage("");
                header("Location: http://Localhost/WebundMultimedia/");
                die;
            }
            $this->errorHandler->setErrorMessage("Bitte geben Sie das korrekte Passwort ein.");
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
            $this->templateEngine->display("\Account\Login.tpl");
        }
        else
        {
            $this->errorHandler->setErrorMessage("Der Benutzername konnte nicht gefunden werden.");
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
            $this->templateEngine->display("\Account\Login.tpl");
        }
    }

    public function register()
    {
        if (!$this->validateAccountCreation())
        {
            header("Location: http://Localhost/WebundMultimedia/user/register");
            die;
        }

        $userName = $this->request->POST("username");
        $password = $this->request->POST("password");

        $query = "INSERT INTO benutzer VALUES('','$userName', '" . User::EncryptPassword($password) . "')";
        $this->database->query($query);

        $this->errorHandler->setErrorMessage("");
        header("Location: http://Localhost/WebundMultimedia/user/login");
        die;
    }

    private function validateAccountCreation()
    {
        $query = "SELECT * FROM benutzer WHERE Benutzername = '" . $this->request->POST("username") . "'";
        $result = $this->database->query($query);

        if ($result->num_rows > 0)
        {
            $this->errorHandler->setErrorMessage("Bitte wählen Sie einen anderen Benutzernamen.");
            return false;
        }
        else
            return true;
    }
}