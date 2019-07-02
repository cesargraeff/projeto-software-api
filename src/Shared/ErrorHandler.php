<?php

namespace Curriculo\Shared;

use Exception;
use PDOException;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandler
{

    private $ci;

    public function __invoke(ContainerInterface $ci)
    {
        $this->ci = $ci;
        
        return function(Request $request, Response $response, Exception $exception){

            $response = $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

            if($exception instanceof PDOException){
                return $this->database($response,$exception);
            }

            return $this->default($response,$exception);
        };
    }

    private function database(Response $response, PDOException $e)
    {
        $err = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];

        return $response->withStatus(500)->withJson($err);
    }

    private function default(Response $response, Exception $e)
    {
        $err = [
            'status' => 'error',
            'message' => $e->getMessage(),
            'details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode()
            ]
        ];

        return $response->withStatus(500)->withJson($err);
    }

}