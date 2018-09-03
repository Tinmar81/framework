<?php
/**
 * Created by PhpStorm.
 * User: tinmar81
 * Date: 03/04/18
 * Time: 15:56
 */

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{

    private $twig;

    private $loader;

    public function __construct(\Twig_Loader_Filesystem $loader, \Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * Allows to add a path for the view
     * @param string $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Allows to render a view
     * The path can be specified with namespaces
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.html.twig', $params);
    }

    /**
     * Allows to add global variables to all views
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value) :void
    {
        $this->twig->addGlobal($key, $value);
    }
}
