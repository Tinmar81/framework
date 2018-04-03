<?php

require '../vendor/autoload.php';

$renderer = new \Framework\Renderer();
$renderer->addPath(dirname(__DIR__). '/app/views');

$app = new \Framework\App([

    \Blog\BlogModule::class

] , [
    'renderer' => $renderer
]);

$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());

\Http\Response\send($response);
