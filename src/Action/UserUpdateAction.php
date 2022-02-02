<?php

namespace App\Action;

use App\Domain\User\Service\UserUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserUpdateAction
{
    private $userUpdater;

    public function __construct(UserUpdater $userUpdater)
    {
        $this->userUpdater = $userUpdater;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {  
        // Collect input from the HTTP request
        $att = (object)$request->getAttributes();
        $body = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $result = $this->userUpdater->selectUser($att->id, $body);

        return $this->respondWithFormat($result, $response);
    }

    private function respondWithFormat(array $data, Response $response): Response {
        
        $errors = $data['errors'] ? true : false;

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($data));

        if($errors){
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(202);
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
