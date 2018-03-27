<?php
/**
 * Created by PhpStorm.
 * User: tinmar81
 * Date: 27/03/18
 * Time: 12:00
 */

namespace Framework\Router;

use GuzzleHttp\Psr7\Response;

;

/**
 * Class Route
 * @package Framework\Router
 */

class Route extends Response
{
    /**
     * @var string
     * @var callable
     * @var array
     */

    private $name;

    private $callback;

    private $parameters;

    private $path;

    public function __construct(string $name, string $path, callable $callback, array $parameters)
    {

        $this->name = $name;
        $this->path = $path;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @return callable
     */
    public function getCallback() : callable
    {
        return $this->callback;
    }

    /**
     * @return array
     */
    public function getParameters() : ?array
    {
        return $this->parameters;
    }
}
