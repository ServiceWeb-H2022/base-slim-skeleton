<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use App\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserReadAction
{
    private $userReader;
    private $logger;
    private $data;

    public function __construct(UserReader $userReader, LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
        ->addFileHandler('test.log')
        ->createLogger("LoggerTest");

        $this->userReader = $userReader;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        //TODO: Remplacer $data par un constructeur ou un factory
        // Collecte les données à partir de la requête HTTP
        $attribs = (object)$request->getAttributes() ?? null;
        $params = (object)$request->getQueryParams() ?? null;
        $body = (object)$request->getParsedBody() ?? null;
        $this->data = (object)["attribs"=>$attribs,"params"=>$params,"body"=>$body];

        // Invoque le Domaine avec les données en entrée et retourne le résultat
        $resultat = $this->userReader->selectUser($data->id ?? 0);

        $resultat = $this->userReader->selectUser($this->data);
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
        $notFoundErrors = $data['notFound-errors'] ? true : false;
        $validationErrors = $data['validation-errors'] ? true : false;

        

        // Envoit les résultats dans le body de la réponse
        $response->getBody()->write((string)json_encode($data));

        if($notFoundErrors){
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
