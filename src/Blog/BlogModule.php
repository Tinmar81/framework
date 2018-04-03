<?php
namespace Blog;

use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogModule
 * @package Blog
 */
class BlogModule
{
    /**
     * @var Router
     */
    protected $router;

    private $renderer;

    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__.'/views');

        $this->router = $router;
        $this->router->addRoute('blog.index', '/blog', [$this, 'index']);
        $this->router->addRoute('blog.show', '/blog/{slug}/{id}', [$this, 'show']);
    }

    /**
     * @return string
     * Manage the view for the main page of the Blog
     */
    public function index(Request $request)
    {
        return $this->renderer->render('@blog/index');
    }

    /**
     * @return string
     * Manage the article rendition
     */
    public function show(Request $request)
    {
        return $this->renderer->render('@blog/show', [
            'slug'=> $request->getAttribute('slug'),
            'id' => $request->getAttribute('id')
        ]);
    }
}
