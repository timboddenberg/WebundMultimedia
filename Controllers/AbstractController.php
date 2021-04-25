<?php

require_once __DIR__ . "\..\Engine\TemplateEngine.php";
require_once __DIR__ . "\..\Engine\DatabaseEngine.php";

class AbstractController
{
    protected TemplateEngine $templateEngine;

    protected mysqli $database;

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->database = DatabaseEngine::getConnection();
    }
}