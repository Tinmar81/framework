<?php

use Framework\Renderer\TwigRendererFactory;
use Framework\Renderer\RendererInterface;
use Framework\Router;

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'application_test',
    'view.path' => dirname(__DIR__) . '/app/views',
    'twig.extensions' => [
        \DI\get(\Framework\Router\RouterTwigExtension::class)
    ],
    Router::class => \DI\autowire(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    \PDO::class => function (\Psr\Container\ContainerInterface $container) {
        return $pdo = new \PDO('mysql:host=' . $container->get('database.host') . ';dbname='.$container->get('database.name'),
                $container->get('database.username'),
                $container->get('database.password'),
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
    }
];