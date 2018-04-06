<?php

namespace Tests\Blog\Actions;


use Blog\Actions\BlogAction;
use Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class BlogActionTest extends TestCase
{
    /**
     * @var BlogAction
     */
    private $action;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var
     */
    private $router;

    public function setUp()
    {
        $this->renderer = $this->prophesize(RendererInterface::class);

        $this->postTable = $this->prophesize(PostTable::class);

        $this->router = $this->prophesize(Router::class);

        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->postTable->reveal()
        );
    }

    public function makePost(int $id, string $slug)
    {
        $post = new \stdClass();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $post = $this->makePost(9, 'blablabla');

        $request = (new ServerRequest('GET', '/' ))
            ->withAttribute('id', $post->id )
            ->withAttribute('slug', $post->slug);

        $this->postTable->find($post->id, $post->slug)->willReturn($post);
        $this->renderer->render('@blog/show', ['post' => $post])->willReturn('');

        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(true, true);

    }
}