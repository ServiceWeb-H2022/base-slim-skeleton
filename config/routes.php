<?php

use App\Middleware\BasicAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
    $app->get('/', \App\Action\Docs\SwaggerUiAction::class)->setName('Docs');


    /**
     * GET	    Selection des usagers
     * POST	    Insertion d'un usager
     */
    $app->group('/users', function (RouteCollectorProxy $group) {
        // $group->get('', \App\Action\UserReadAction::class);
        $group->post('', \App\Action\UserCreateAction::class);
    });

    /**
     * GET	   	Lister seulement l'usager avec le id en paramètre
     * PUT	   	Modifier l'usager avec le id en paramètre
     * DELETE	Supprimer l'usager avec le id en paramètre
     */
     $app->group('/users/{id:[0-9]+}', function (RouteCollectorProxy $group) {
         $group->get('', \App\Action\UserReadAction::class);

         // FIXME: Fonctionne seulement avec tout les champ user fournis
         $group->put('', \App\Action\UserUpdateAction::class);
         
         $group->delete('', \App\Action\UserDeleteAction::class);
     });


};

