<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserUpdateAction
{
    private $usagerUpdater;
    private $usagerReader;

    public function __construct(
        UserUpdater $usagerUpdater,
        UserReader $usagerReader)
    {
        $this->userUpdater = $usagerUpdater;
        $this->userReader = $usagerReader;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collecte les données à partir de la requête HTTP
        $data = (array)$request->getParsedBody();
        $data['id'] = (int)$request->getAttribute('id');

        // Invoque le Domaine avec les données en entrée et retourne le résultat
        $updateResult = $this->userReader->selectUser($data['id']);
        
        if( ! $updateResult['notFound-errors'] )
            $updateResult = $this->userUpdater->updateUser($data);

        if( ! $updateResult['validation-errors'] )
            $updateResult = $this->userReader->selectUser($data['id']);


        // Construit la réponse HTTP
        return $this->respondWithFormat($updateResult, $response);
    }


    /**
     * @param array $data Les données qui seront utiliser pour la réponse
     * 
     * @param Response $response l'objet réponse pour la requête en cours
     * 
     * @return Response $response La réponse fromaté selon l'algorithme
     */
    private function respondWithFormat(array $data, Response $response): Response {

        // Envoit les résultats dans le body de la réponse
        $response->getBody()->write((string)json_encode($data));


        if($data['validation-errors']){
            // Logging here: User creation failed
            //$this->logger->info(sprintf('User was not Updated: %s', $resultat));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
        }

        if($data['notFound-errors']){
            // Logging here: User creation failed
            //$this->logger->info(sprintf('User was not Updated: %s', $resultat));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
        }


        // Logging here: User Updated successfully
        //$this->logger->info(sprintf('User Updated successfully: %s', $resultat));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
