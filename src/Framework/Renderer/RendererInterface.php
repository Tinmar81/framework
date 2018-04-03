<?php

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * Allows to add a path for the view
     * @param string $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * Allows to render a view
     * The path can be specified with namespaces
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * Allows to add global variables to all views
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void;
}
