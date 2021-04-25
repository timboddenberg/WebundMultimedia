<?php

require_once __DIR__ . "\AbstractController.php";

class CreatorController extends AbstractController
{
    function loadCreator()
    {
        $this->templateEngine->display("\Login\UserCreator.tpl");
    }
    function create()
    {
        $salt1 = "qm&h*";
        $salt2 = "pg!@";
        $user = $_POST["username"];
        $password = $_POST["password"];
        $token = hash('ripemd128', "$salt1$password$salt2");
        $query = "INSERT INTO benutzer VALUES('$user', '$token')";
        $this->database->query($query);
    }
}