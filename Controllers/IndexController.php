<?php

require_once __DIR__ . "\AbstractController.php";

class IndexController extends AbstractController
{
    function loadIndex()
    {
        $this->render("Index/Index.tpl", [
            "message" => "Schalke ist Scheiße. !!"
        ]);
    }
}