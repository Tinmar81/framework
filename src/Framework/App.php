<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerResponseInterface;


class App
{
    public function run(ServerRequestInterface $request){

        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === '/') {

            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri,0,-1));
        }

        if ($uri === '/blog') {
            return new Response(200, [], '<h1>Welcome on the blog...</h1>');
        }

        return new Response (404, [], '<h1>Oups... this page does not exist</h1>');
    }
}