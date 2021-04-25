<?php

class TemplateEngine
{
    private string $templateContent;
    private string $layoutTemplateContent;

    private string $compiledHtml;

    private array $variables = [];

    public function __construct()
    {
        $this->fetchLayoutTemplateContent();
    }

    public function display(string $template)
    {
        $this->fetchTemplateContent($template);
        $this->replaceVariablesWithValues();
        $this->replaceBodyContent();

        echo $this->compiledHtml;
    }

    public function addVariable(string $name, string $value)
    {
        if (array_key_exists($name, $this->variables))
            die("Variablen-Schlüssel" . $name . "wurde doppelt hinzugefügt");

        $this->variables[$name] = $value;
    }

    private function fetchLayoutTemplateContent()
    {
        $this->layoutTemplateContent = file_get_contents(__DIR__ . "\..\Views\Layout.tpl");
    }

    private function fetchTemplateContent(string $template)
    {
        $this->templateContent = file_get_contents(__DIR__ . "\..\Views\\" . $template);
    }

    private function replaceVariablesWithValues()
    {
        if (empty($this->variables)) return;

        foreach ($this->variables as $key => $value) {
            $this->templateContent = str_replace('{$' . $key . '}',$this->variables[$key], $this->templateContent);
        }
    }

    private function replaceBodyContent()
    {
        $this->compiledHtml = str_replace("{body}", $this->templateContent, $this->layoutTemplateContent);
    }

}