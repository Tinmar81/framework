<?php

namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

class TwigRendererFactory
{

    public function __invoke(ContainerInterface $container) : TwigRenderer
    {
        $viewPath = $container->get('view.path');
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader);

        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        return new TwigRenderer($loader, $twig);
    }
}
