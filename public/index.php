<?php

require '../vendor/autoload.php';

$twigRenderer = new \Framework\Renderer\TwigRenderer(dirname(__DIR__) . '/app/views');

$app = new \Framework\App([

    \Blog\BlogModule::class

], [
    'renderer' => $twigRenderer
]);

$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());

\Http\Response\send($response);
