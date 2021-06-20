<?php

require_once __DIR__ . "\AbstractController.php";

class IndexController extends AbstractController
{
    // This method displays the index view
    function loadIndex()
    {

        $this->templateEngine->display("Index\Index.tpl");
    }
}