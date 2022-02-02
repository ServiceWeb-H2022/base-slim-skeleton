<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

final class UserReadAction
{
    private $userReader;

    public function __construct(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {  
        // Collect input from the HTTP request
        $data = (object)$request->getAttributes();

        // Invoke the Domain with inputs and retain the result
        $data = $this->userReader->selectUser($data->id);

        return $this->respondWithFormat($data, $response);
    }

    private function respondWithFormat(array $data, Response $response): Response {
        
        $errors = $data['errors'] ? true : false;
        $result = $errors ? $data['errors'] : $data;

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

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
