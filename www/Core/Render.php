<?php
namespace App\Core;

class Render
{
    private string $viewPath;
    private string $templatePath;
    private array $data = [];
    private string $basePath;

    public function __construct(string $view, string $template = "frontoffice")
    {
        // Get the base path of the www directory
        $this->basePath = __DIR__ . "/..";
        $this->setViewPath($view);
        $this->setTemplatePath($template);
    }

    public function setViewPath(string $view): void
    {
        $this->viewPath = $this->basePath . "/Views/" . $view . ".php";
    }

    public function setTemplatePath(string $template): void
    {
        $this->templatePath = $this->basePath . "/Views/Templates/" . $template . ".php";
    }

    public function assign(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function render(): void
    {
        extract($this->data);
        $viewPath = $this->viewPath;
        include $this->templatePath;
    }
}