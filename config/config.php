<?php

use Framework\Renderer\TwigRendererFactory;
use Framework\Renderer\RendererInterface;
use Framework\Router;

return [
    'view.path' => dirname(__DIR__) . '/app/views',
    'twig.extensions' => [
        \DI\get(\Framework\Router\RouterTwigExtension::class)
    ],
    Router::class => \DI\autowire(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class)
    ];