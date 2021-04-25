<?php

require_once __DIR__ . "\AbstractController.php";

class IndexController extends AbstractController
{
    function loadIndex()
    {
        $this->display("Layout.tpl");
        $this->database->query("SELECT baslasdkasjdkadnjasdn");
    }
}