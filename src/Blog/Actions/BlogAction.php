<?php

namespace Blog\Actions;

use Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var Router
     */
    private $router;

    use RouterAwareAction;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        $slug = $request->getAttribute('slug');
        if ($slug) {
            return $this->show($request);
        } else {
            return $this->index($request);
        }
    }

    /**
     * Manage the view for the main page of the Blog
     * @return string
     */
    public function index(Request $request)
    {
        $posts = $this->postTable->findPaginated();
        return $this->renderer->render('@blog/index', ['posts'=>($posts)]);
    }

    /**
     * Shows an article
     * @param Request $request
     * @return ResponseInterface | string
     * @throws \Aura\Router\Exception\RouteNotFound
     */
    public function show(Request $request)
    {
        $post = $this->postTable->find(
            $request->getAttribute('id'),
            $request->getAttribute('slug')
        );

        if (!$post) {
            return new Response(404, [], '<h1>Oups... this page does not exist</h1>');
        }

        if ($post->slug !== $request->getAttribute('slug')) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }

        return $this->renderer->render('@blog/show', [
            'post' => $post
        ]);
    }
}
