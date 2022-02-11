<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use App\Factory\LoggerFactory;
use App\Factory\RequestDataFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserReadAction
{
    private $userReader;
    private $logger;
    private $requestData;

    public function __construct(UserReader $userReader, 
    RequestDataFactory $requestDataFactory, LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
        ->addFileHandler('test.log')
        ->createLogger("LoggerTest");

        $this->requestData = $requestDataFactory;
        $this->userReader = $userReader;
    }

    public function __invoke(
        ServerRequestInterface $request, ResponseInterface $response
    ): ResponseInterface {

        // Collecte les données à partir de la requête HTTP
        $this->requestData = $this->requestData->createData($request);


        $resultat = $this->userReader->selectUser($this->requestData);
        return $this->respondWithFormat($resultat, $response);
    }


    /**
     * @param array $atts Les données qui seront utilisées pour la réponse
     * 
     * @param Response $response l'objet réponse pour la requête en cours
     * 
     * @return Response $response La réponse fromaté selon l'algorithme
     */
    private function respondWithFormat(array $atts, Response $response): Response
    {

        $errors = $atts['errors'] ? true : false;
        $notFoundErrors = $atts['notFound-errors'] ? true : false;
        $validationErrors = $atts['validation-errors'] ? true : false;



        // Envoit les résultats dans le body de la réponse
        $response->getBody()->write((string)json_encode($atts));

        if ($notFoundErrors) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
