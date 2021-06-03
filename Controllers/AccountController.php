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
        User::validateUserRequest($this->user);

        $this->templateEngine->display("\Account\UserRemover.tpl");
    }

    public function displayLogin()
    {
        $this->templateEngine->display("\Account\Login.tpl");
    }

    public function displayLogout()
    {
        $this->templateEngine->display("\Account\Logout.tpl");
    }
    /*
     * Method runs the logout and clears user and userID keys in the session
     */
    public function performLogout()
    {
        User::validateUserRequest($this->user);
        $this->request->setSESSION("user", serialize(new User("")));
        $this->request->setSESSION('userID','');

        header("Location: http://Localhost/WebundMultimedia/user/logout");
    }
    public function displayRegister()
    {
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
                $user->setUserId($row[0]);
                $user->setFirstName($row[3]);
                $user->setLastName($row[4]);
                $user->setIsAdmin($row[5]);

                $this->request->setSESSION("user",serialize($user));
                $this->request->setSESSION('userID', $row[0]);

                $this->errorHandler->setErrorMessage("");
                header("Location: http://Localhost/WebundMultimedia/");
                die;
            }
            $this->errorHandler->setErrorMessage("Bitte geben Sie das korrekte Passwort ein.");
            header("Location: http://Localhost/WebundMultimedia/user/login");
            die;
        }
        else
        {
            $this->errorHandler->setErrorMessage("Der Benutzername konnte nicht gefunden werden.");
            header("Location: http://Localhost/WebundMultimedia/user/login");
            die;
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

        $query = "INSERT INTO benutzer VALUES('','$userName', '" . User::EncryptPassword($password) . " ', '$firstname', '$lastname','')";
        $this->database->query($query);

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
    public function performRemove()
    {
        User::validateUserRequest($this->user);

        $password = $this->request->POST("password");
        $username = $this->request->SESSION('userID');

        $query = "DELETE FROM benutzer WHERE Passwort = '" . User::EncryptPassword($password) . " ' AND Id = '$username'";
        $this->database->query($query);

        $this->request->setSESSION("user", serialize(new User("")));
        $this->request->setSESSION('userID','');

        header("Location: http://Localhost/WebundMultimedia/");
    }

    public function displayUserAdministration()
    {
        User::validateAdminRequest($this->user);

        $query = "SELECT * FROM benutzer";
        $result = $this->database->query($query);
        $userArray = array();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $user = new User($row["Benutzername"]);
                $user->setUserId($row["Id"]);
                $user->setFirstName($row["Vorname"]);
                $user->setLastName($row["Nachname"]);
                $user->setIsAdmin($row["Admin"]);

                array_push($userArray, $user);
            }
        }

        $this->request->setSESSION("userArray",serialize($userArray));
        $this->templateEngine->display("\Account\UserAdministration.tpl");
    }

    public function getUserAdministrationColumnHtml()
    {
        $firstNameSearchTerm = $this->request->GET("firstNameSearchTerm");
        $lastNameSearchTerm = $this->request->GET("lastNameSearchTerm");
        $categorySearchTerm = $this->request->GET("categorySearchTerm");

        $userArray = unserialize($this->request->SESSION("userArray"));
        $html = "";

        foreach ($userArray as $user)
        {
            if ($firstNameSearchTerm == "" || str_contains($user->getFirstName(),$firstNameSearchTerm))
            {
                if ($lastNameSearchTerm == "" || str_contains($user->getLastName(),$lastNameSearchTerm))
                {
                    if ($categorySearchTerm == "" || str_contains($user->getUserCategory(),$categorySearchTerm))
                    {
                        $html = $html .
                            "<div class='row userColumn'>
                        <div class='col-md-3'>" .
                            $user->getFirstName() . "
                        </div>                   
                        <div class='col-md-3'>" .
                            $user->getLastName() . "
                        </div>                   
                        <div class='col-md-3'>" .
                            $user->getUserCategory() . "
                        </div>
                        <div class='col-md-2'>
                            <a href='/WebundMultimedia/user/administration/updateUserAdminStatusById?UserId=" . $user->getUserId() . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-shift-fill' viewBox='0 0 16 16'>
                                    <path d='M7.27 2.047a1 1 0 0 1 1.46 0l6.345 6.77c.6.638.146 1.683-.73 1.683H11.5v3a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-3H1.654C.78 10.5.326 9.455.924 8.816L7.27 2.047z'/>
                                </svg>
                            </a>
                        </div>
                        <div class='col-md-1'>
                            <a href='/WebundMultimedia/user/administration/removeUserById?UserId=" . $user->getUserId() . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                    <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                </svg>
                            </a>
                        </div>
                     </div>";
                    }
                }
            }
        }

        echo $html;

    }

    public function removeUserById()
    {
        $userId = $this->request->GET("UserId");

        $query = "DELETE FROM benutzer WHERE Id = '$userId'";
        $this->database->query($query);

        header("Location: http://Localhost/WebundMultimedia/user/administration");
    }

    public function updateUserAdminStatusById()
    {
        $userId = $this->request->GET("UserId");

        $query = "UPDATE Benutzer SET Admin = 1 WHERE Id = '$userId'";
        $this->database->query($query);

        header("Location: http://Localhost/WebundMultimedia/user/administration");
    }
}