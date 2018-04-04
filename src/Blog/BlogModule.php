<?php
namespace Blog;

use Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;

/**
 * Class BlogModule
 * @package Blog
 */
class BlogModule extends Module
{
    const DEFINITIONS = __DIR__ . '/config.php';


    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__.'/views');

        $router->addRoute('blog.index', $prefix, BlogAction::class);
        $router->addRoute('blog.show', $prefix . '/{slug}/{id}', BlogAction::class);
    }
}
