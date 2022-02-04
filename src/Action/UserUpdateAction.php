<?php

namespace App\Action;

use App\Domain\User\Service\userUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserUpdateAction
{
    private $userUpdater;

    public function __construct(userUpdater $userUpdater)
    {
        $this->userUpdater = $userUpdater;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $result = $this->userUpdater->UpdateUser($data);

        // Build the HTTP response
        return $this->respondWithFormat($result, $response);
    }

    private function respondWithFormat(array $data, Response $response): Response {
        
        $errors = $data['errors'] ? true : false;

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($data));


        if($errors){
            // Logging here: User creation failed
            //$this->logger->info(sprintf('User was not Updated: %s', $result));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
        }


        // Logging here: User Updated successfully
        //$this->logger->info(sprintf('User Updated successfully: %s', $result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
