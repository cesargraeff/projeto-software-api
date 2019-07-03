<?php

namespace Curriculo\Controller;


use Curriculo\Shared\Controller;
use Interop\Container\ContainerInterface;
use Curriculo\Model\AlunoModel;
use Slim\Http\Request;
use Slim\Http\Response;


class AlunoController extends Controller
{

    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci, (new AlunoModel($ci)));
    }

    private $validators = [
        'nome' => V::length(3, 100)->notBlank(),
        'cpf' => V::numeric(),
        'endereco' => V::length(3,50),
        'numero' => V::numeric(),
        'bairro' => V::length(3,50),
        'municipio' => V::numeric()
    ];

    public function adicionar(Request $request, Response $response)
    {
        
        $validator = $this->ci->validator->validate($request, $this->validators);
        
        if ($validator->isValid()) {

            $data = $request->getParsedBody();

            $id = $this->model->adicionar($data);

            return $response->withStatus(201)->withJson([
                'status' => 'success',
                'id' => $id
            ]);

        } else {
            $response->withStatus(201)->withJson([
                'status' => 'error',
                'errors' => $validator->getErrors()
            ]);
        }
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