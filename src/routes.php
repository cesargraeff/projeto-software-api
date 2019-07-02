<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Curriculo\Controller\CursoController;
use Curriculo\Controller\AlunoController;
use Curriculo\Controller\CurriculoController;

return function (App $app) {

    $container = $app->getContainer();

    $app->get(
        '/', function (Request $request, Response $response){
        return $response->withJson(
            [
                'api_name' => 'Controle de Currículo',
                'api_version' => '1.0.0',
            ]
        );
    });

    $app->group(
        '/api/{version}', function (App $app) {

            $app->group(
                '/alunos', function (App $app) {
    
                    $app->get('', AlunoController::class.':listar');
                    $app->get('/{id}', AlunoController::class.':buscar');
                    $app->post('', AlunoController::class.':adicionar');
                    $app->put('/{id}', AlunoController::class.':editar');
                }
            );
            
            $app->group(
                '/curriculos', function (App $app) {
    
                    $app->get('', CurriculoController::class.':listar');
                    $app->get('/{id}', CurriculoController::class.':buscar');
                    $app->post('', CurriculoController::class.':adicionar');
                    $app->put('/{id}', CurriculoController::class.':editar');
                }
            );

            $app->group(
                '/cursos', function (App $app) {
    
                    $app->get('', CursoController::class.':listar');
                    $app->get('/{id}', CursoController::class.':buscar');
                    $app->post('', CursoController::class.':adicionar');
                    $app->put('/{id}', CursoController::class.':editar');
                }
            );
        }
    );

};
