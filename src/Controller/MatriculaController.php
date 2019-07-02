<?php

namespace Curriculo\Controller;


use Curriculo\Shared\Controller;
use Interop\Container\ContainerInterface;
use Curriculo\Model\MatriculaModel;
use Slim\Http\Request;
use Slim\Http\Response;


class MatriculaController extends Controller
{

    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci, (new MatriculaModel($ci)));
    }


    public function adicionar(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $id = $this->model->adicionar($data);

        return $response->withStatus(201)->withJson([
            'status' => 'success',
            'id' => $id
        ]);
    }

    public function editar(Request $request, Response $response, array $args)
    {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $this->model->editar($id, $data);

        return $response->withJson([
            'status' => 'success'
        ]);
    }

    public function buscar(Request $request, Response $response, array $args)
    {
        $res = $this->model->buscar($args['id']);

        return $response->withJson([
            'status' => 'success',
            'data' => $res
        ]);
    }

    public function listar(Request $request, Response $response)
    {
        $res = $this->model->listar();

        return $response->withJson([
            'status' => 'success',
            'data' => $res
        ]);
    }

}