<?php

namespace App\Action;

use App\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
        ->addFileHandler("HomeAction.log")
        ->createLogger('HomeAction: ');
    }


    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        
        $resultat = json_encode([
            'success' => true, 
            'message' => 'Hello world!'
        ]);
        
        $response->getBody()->write($resultat);

        $this->logger->info('Hello from homeEndpoint...');
        return $response->withHeader('Content-Type', 'application/json');
    }
}
