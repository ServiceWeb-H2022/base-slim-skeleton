<?php

use App\Middleware\BasicAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
    $app->get('/', \App\Action\Docs\SwaggerUiAction::class)->setName('Docs');


    /**
     * GET	    /users/	 Selection des usagers
     * POST	    /users/	 Insertion d'un usager
     */
    $app->group('/users}', function (RouteCollectorProxy $group) {
        $group->get('/{order}', \App\Action\UserCreateAction::class);
        $group->post('/users', \App\Action\UserCreateAction::class);
    });

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

