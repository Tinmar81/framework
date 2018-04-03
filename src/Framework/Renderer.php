<?php

namespace Framework;

class Renderer
{
    const DEFAULT_NAMESPACE = '__MAIN';
    private $globals=[];
    private $paths=[];


    /**
     * Allows to add a path for the view
     * @param string $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null) : void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }else {
            $this->paths[$namespace] = $path;
        }
    }


    /**
     * Allows to render a view
     * The path can be specified with namespaces
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params=[]): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        }else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . '/' . $view . '.php';
        }

        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require "$path";
        return ob_get_clean();

    }

    /**
     * Allows to add global variables to all views
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void {
        $this->globals[$key] = $value;
    }

    private function hasNamespace(string $view): bool {
        return $view[0] === "@";
    }

    private function getNamespace(string $view): string {
        return substr($view, 1, strpos($view , '/')-1);
    }

    private function replaceNamespace(string $view): string {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}