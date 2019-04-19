<?php declare(strict_types=1);

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return static function (App $app) {

    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Homepage');

        return $response;
    })->setName('home');


    $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");

        return $response;
    });
};
