<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    // Ajout d'un middleware pour analyser: json, form data et xml
    $app->addBodyParsingMiddleware();

    $app->add(TwigMiddleware::class);

    // Permettre les CORS
    $app->add(\App\Middleware\CorsMiddleware::class);

    // Ajoute le middleware natif de SLIM pour le routage
    $app->addRoutingMiddleware();

    // Ajoute la configuration d'un chemin de base
    $app->add(BasePathMiddleware::class);


    
    // Permet de récupérer les érreurs et exceptions
    // !!!! DOIT TOUJOURS ÊTRE LE DERNIER MIDDLEWARE !!!! \\
    $app->add(ErrorMiddleware::class);
};
