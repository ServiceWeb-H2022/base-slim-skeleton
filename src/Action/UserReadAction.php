<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserReadAction
{
    private $usagerReader;

    public function __construct(UserReader $usagerReader)
    {
        $this->userReader = $usagerReader;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {  
        // Collecte les données à partir de la requête HTTP
        $data = (object)$request->getAttributes();

        // Invoque le Domaine avec les données en entrée et retourne le résultat
        $resultat = $this->userReader->selectUser($data->id);

        return $this->respondWithFormat($resultat, $response);
    }


    /**
     * @param array $data Les données qui seront utilisées pour la réponse
     * 
     * @param Response $response l'objet réponse pour la requête en cours
     * 
     * @return Response $response La réponse fromaté selon l'algorithme
     */
    private function respondWithFormat(array $data, Response $response): Response {
        
        $errors = $data['errors'] ? true : false;

        // Envoit les résultats dans le body de la réponse
        $response->getBody()->write((string)json_encode($data));

        if($errors){
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
