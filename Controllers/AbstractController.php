<?php

require_once __DIR__ . "\..\TemplateEngine\ProjectTemplate.php";

class AbstractController
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new ProjectTemplate();
    }

    public function render(string $template, array $variables = [])
    {
        foreach ($variables as $key => $variable)
        {
            $this->smarty->assign($key, $variable);
        }

        $this->smarty->display($template);
    }



}