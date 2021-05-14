<?php

require_once __DIR__ . "\AbstractController.php";

class IndexController extends AbstractController
{
    function loadIndex()
    {

        $this->templateEngine->display("Index\Index.tpl");
    }
}