<?php

namespace Curriculo\Controller;


use Curriculo\Shared\Controller;
use Interop\Container\ContainerInterface;
use Curriculo\Model\LoginModel;
use Slim\Http\Request;
use Slim\Http\Response;


class LoginController extends Controller
{

    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci, (new LoginModel($ci)));
    }

    public function login(Request $request, Response $response){

        return $response->withJson([
            'status' => 'success'
        ]);
    }

}