<?php
namespace Blog;

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

    public function __construct(Router $router)
    {

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

        return '<h1>Welcome on the blog module</h1>';
    }

    /**
     * @return string
     * Manage the article rendition
     */
    public function show(Request $request)
    {

        return '<h1>Welcome on ' . $request->getAttribute('slug') . '-' . $request->getAttribute('id') . '</h1>';
    }
}
