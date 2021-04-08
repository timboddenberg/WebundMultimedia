<?php

class IndexController
{
    function loadIndex()
    {
        return require_once __DIR__ . "\..\Views\Index.html";
    }
}