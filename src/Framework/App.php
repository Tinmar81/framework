<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
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
    private $router;

    public function __construct($modules, array $dependencies = [])
    {

        $this->router = new Router();

        if (array_key_exists('renderer', $dependencies)) {
            $dependencies['renderer']->addGlobal('router', $this->router);
        }

        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $dependencies['renderer']);
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
        $route = $this->router->matchRoute($request);

        //If nothing matches then return a 404
        if (is_null($route)) {
            return new Response(404, [], '<h1>Oups... this page does not exist</h1>');
        }

        $parameters =$route->getParameters();

        $request = array_reduce(array_keys($parameters), function ($request, $key) use ($parameters) {

            return $request->withAttribute($key, $parameters[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of Resposne Interface');
        }
    }
}
