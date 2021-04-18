<?php

require_once __DIR__ . "\libs\Smarty.class.php";

class ProjectTemplate extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(__DIR__ . "\..\Views\\");
        $this->setCompileDir(__DIR__ . "\..\\temp\\templates_compiled\\");
        $this->setConfigDir(__DIR__ . "\..\\temp\\configs\\");
        $this->setCacheDir(__DIR__ . "\..\\temp\\template_cache\\");
    }
}