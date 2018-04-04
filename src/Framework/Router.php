<?php

namespace Framework;

use Aura\Router\RouterContainer;
use \Aura\Router\Route as AuraRoute;
use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Router
 * @package Framework
 */
class Router
{
    /**
     * @var RouterContainer
     */

    protected $router;
    protected $map;

    public function __construct()
    {

        $this->router = new RouterContainer();
    }

    /**
     * @param String $name
     * @param String $path
     * @param string|callable $callable
     *
     * Register a route in the Router mapping
     */
    public function addRoute(String $name, String $path, $callable)
    {

        $map = $this->router->getMap();
        $map->get($name, $path, $callable);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function matchRoute(ServerRequestInterface $request)
    {

        $matcher = $this->router->getMatcher();
        $route = $matcher->match($request);

        if ($route instanceof AuraRoute) {
             return new Route(
                 $route->name,
                 $route->path,
                 $route->handler,
                 $route->attributes
             );
        } else {
            return null;
        }
    }


    /**
     * Allows to get a Uri from a route name
     * @param string $name
     * @param array $params
     * @return false|string
     * @throws \Aura\Router\Exception\RouteNotFound
     */
    public function generateUri(string $name, array $params = [])
    {
        return $this->router->getGenerator()->generate($name, $params);
    }
}
