<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');


    /**
     * $app->get('/users', \App\Action\UserCreateAction::class);
     * GET	/users/{id}	Lister seulement l'usager avec le id en paramètre
     * PUT	/users/{id}	Modifier l'usager avec le id en paramètre
     * DELETE	/users/{id}	Supprimer l'usager avec le id en paramètre
     */
     $app->group('/users/{id:[0-9]+}', function (RouteCollectorProxy $group) {
         $group->get('', \App\Action\UserReadAction::class);
         $group->put('', \App\Action\UserReadAction::class);

         $group->delete('', function(Request $request, Response $response, array $arguments): Response {

            return $response;
         });
     });


    $app->post('/users/', \App\Action\UserCreateAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

};

