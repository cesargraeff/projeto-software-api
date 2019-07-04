<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Curriculo\Controller\CursoController;
use Curriculo\Controller\AlunoController;
use Curriculo\Controller\CurriculoController;
use Curriculo\Controller\DisciplinaController;
use Curriculo\Controller\LoginController;
use Curriculo\Controller\MatriculaController;
use Curriculo\Controller\RequisitoController;
use Curriculo\Controller\UsuarioController;

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

    $app->post('/login', LoginController::class.':login');

    $app->group(
        '/{version}', function (App $app) {

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

                    $app->get('/aluno/{id}', CurriculoController::class.':visualizar');
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

            $app->group(
                '/disciplinas', function (App $app) {
    
                    $app->get('', DisciplinaController::class.':listar');
                    $app->get('/{id}', DisciplinaController::class.':buscar');
                    $app->post('', DisciplinaController::class.':adicionar');
                    $app->put('/{id}', DisciplinaController::class.':editar');
                }
            );

            $app->group(
                '/matriculas', function (App $app) {
    
                    $app->get('', MatriculaController::class.':listar');
                    $app->get('/{id}', MatriculaController::class.':buscar');
                    $app->post('', MatriculaController::class.':adicionar');
                    $app->put('/{id}', MatriculaController::class.':editar');
                }
            );

            $app->group(
                '/requisitos', function (App $app) {
    
                    $app->get('', RequisitoController::class.':listar');
                    $app->get('/{id}', RequisitoController::class.':buscar');
                    $app->post('', RequisitoController::class.':adicionar');
                    $app->put('/{id}', RequisitoController::class.':editar');
                }
            );

            $app->group(
                '/usuarios', function (App $app) {
    
                    $app->get('', UsuarioController::class.':listar');
                    $app->get('/{id}', UsuarioController::class.':buscar');
                    $app->post('', UsuarioController::class.':adicionar');
                    $app->put('/{id}', UsuarioController::class.':editar');
                }
            );
        }
    );

};
