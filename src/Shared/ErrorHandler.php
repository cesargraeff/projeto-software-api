<?php

namespace Curriculo\Shared;

use Exception;
use PDOException;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Curriculo\Exception\ValidationException;

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


            if($exception instanceof ValidationException){
                return $this->validation($response,$exception);
            }

            return $this->default($response,$exception);
        };
    }

    private function validation(Response $response, ValidationException $e)
    {
        $err = [
            'status' => 'error',
            'message' => $e->getMessage(),
            'errors' => $e->getErrors()
        ];

        return $response->withStatus(400)->withJson($err);
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