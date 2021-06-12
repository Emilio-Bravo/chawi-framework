<?php

namespace Core\Client;

class View
{

    private string $view_path = __DIR__ . '/../../app/frontend/views/';
    private string $layout_path = __DIR__ . '/../../app/frontend/layouts/';
    private array $files = [];

    public function render(string $file, array $vars = [])
    {
        $content = $this->transform("{$this->view_path}$file.php", $vars);
        return $this->buildLayout($content);
    }

    private function transform(string $path, array $vars = [])
    {
        ob_start();
        foreach ($vars as $var => $value) {
            $$var = $value;
        }
        foreach ((array) $this->getViewDependencies() as $helper => $class) {
            $$helper = $class;
        }
        require_once $path;
        return ob_get_clean();
    }

    private function buildLayout($file_content)
    {
        preg_match_all('/{{+[\w\d]+}}/', $file_content, $matches);

        foreach ($matches[0] as $match) {
            $sanitized = preg_replace('/[{}]/', '', $match);
            (array) $this->files[] = $this->transform("{$this->layout_path}$sanitized.php");
        }

        return str_ireplace($matches[0], $this->files, $file_content);
    }

    private function getViewDependencies()
    {
        return [
            '_session' => new \Core\Http\Persistent,
            '_flash' => new \Core\Support\Flash,
            '_view' => new \Core\Client\ViewHelper
        ];
        //return require_once __DIR__ . '/../../core/config/viewDependencies.php';
    }
}
