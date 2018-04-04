<?php

namespace Blog\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{
    private $renderer;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $id = $request->getAttribute('id');
        if ($slug && $id) {
            return $this->show($slug, $id);
        } else {
            return $this->index($request);
        }
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
    public function show(string $slug, string $id)
    {
        return $this->renderer->render('@blog/show', [
            'slug'=> $slug,
            'id' => $id
        ]);
    }
}
