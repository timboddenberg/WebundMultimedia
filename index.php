<?php

session_start();

include "Engine/RouterEngine.php";

$router = new RouterEngine();

$router->handleRequest();
