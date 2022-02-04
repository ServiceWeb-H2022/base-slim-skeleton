<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {

    // Messsage de bienvenue
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Insertion d'un usager
    $app->post('/users/', \App\Action\UserCreateAction::class);


    /**
     * GET	    /users/{id}	Lister seulement l'usager avec le id en paramètre
     * PUT	    /users/{id}	Modifier l'usager avec le id en paramètre
     * DELETE	/users/{id}	Supprimer l'usager avec le id en paramètre
     */
     $app->group('/users/{id:[0-9]+}', function (RouteCollectorProxy $group) {
         $group->get('', \App\Action\UserReadAction::class);
         $group->put('', \App\Action\UserUpdateAction::class);
         $group->delete('', \App\Action\UserUpdateAction::class);
     });


};

