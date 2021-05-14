<?php

require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\User.php";

class AccountController extends AbstractController
{
    /*
     * the methods checks if the user is logged in:
     * if yes: the user can delete his account
     * if no: the user has to log in
     */
    public function displayUserRemover(){
        $userId = $_SESSION['userID'];
        if($userId != ''){
            $this->templateEngine->display("\Account\UserRemover.tpl");
        }
        else{
            header("Location: http://Localhost/WebundMultimedia/user/login");
        }

    }
    public function displayLogin()
    {
        if ($this->errorHandler->errorOccurred())
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
        else
            $this->templateEngine->addVariable("accountErrorMessage","");

        $this->templateEngine->display("\Account\Login.tpl");
    }
    public function displayLogout()
    {
        if ($this->errorHandler->errorOccurred())
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
        else
            $this->templateEngine->addVariable("accountErrorMessage","");
        $this->templateEngine->display("\Account\Logout.tpl");
    }
    /*
     * Method runs the logout and clears user and userID keys in the session
     */
    public function performLogout()
    {
        $this->request->setSESSION("user", serialize(new User("")));
        $this->request->setSESSION('userID','');
        if ($this->errorHandler->errorOccurred())
            $this->templateEngine->addVariable("accountErrorMessage",$this->errorHandler->getErrorMessage());
        else
            $this->templateEngine->addVariable("accountErrorMessage","");
        header("Location: http://Localhost/WebundMultimedia/user/logout");
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
                $user->setFirstName($row[3]);

                $this->request->setSESSION("user",serialize($user));
                $this->request->setSESSION('userID', $row[0]);

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
        $firstname = $this->request->POST("firstname");
        $lastname = $this->request->POST("lastname");
        $userName = $this->request->POST("username");
        $password = $this->request->POST("password");

        $query = "INSERT INTO benutzer VALUES('','$userName', '" . User::EncryptPassword($password) . " ', '$firstname', '$lastname')";
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

    /*
     * This method removes a user from the database
     */
    public function performRemove(){
        $password = $this->request->POST("password");
        $username = $this->request->SESSION('userID');
        $query = "DELETE FROM benutzer WHERE Passwort = '" . User::EncryptPassword($password) . " ' AND Id = '$username'";
        $this->database->query($query);
        $this->request->setSESSION("user", serialize(new User("")));
        $this->request->setSESSION('userID','');
        header("Location: http://Localhost/WebundMultimedia/");
    }
}