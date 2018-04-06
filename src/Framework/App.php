<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerResponseInterface;

/**
 * Class App
 * @package Framework
 */
class App
{

    private $modules=[];
    private $container;

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param array $modules
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, array $modules)
    {
        $this->container = $container;

        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    public function run(ServerRequestInterface $request)
    {

        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === '/') {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        //Try to match the route
        $route = $this->container->get(Router::class)->matchRoute($request);

        //If nothing matches then return a 404
        if (is_null($route)) {
            return new Response(404, [], '<h1>Oups... this page does not exist</h1>');
        }

        $parameters = $route->getParameters();

        $request = array_reduce(array_keys($parameters), function ($request, $key) use ($parameters) {
            return $request->withAttribute($key, $parameters[$key]);
        }, $request);

        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }

        $response = call_user_func_array($callback, [$request]);


        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of Resposne Interface');
        }
    }

    /**
     * @return ContainerInterface
     *
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
