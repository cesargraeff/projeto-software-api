<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class AlunoModel extends Model
{

    protected $table = 'alunos';

    protected $fillable = [
        'nome',
        'cpf',
        'endereco',
        'numero',
        'bairro',
        'municipio',
        'estado',
        'curriculo_id',
        'login'
    ];
    
    protected $validators = [
        'nome' => 'required|min:3|max:100',
        'cpf' => 'required',
        'curriculo_id' => 'required|numeric'
    ];

    
    function adicionar(array $data): int
    {
        $this->db->getConnection()->beginTransaction();

        $login = new LoginModel($this->ci);
        $data['login'] = $login->adicionar($data['login']);
        
        $res = parent::adicionar($data);
        
        $this->db->getConnection()->commit();
        return $res;
    }

    function editar(int $id, array $data)
    {
        $this->db->getConnection()->beginTransaction();

        $login = new LoginModel($this->ci);
        $login->editar($data['login']['id'],$data['login']);
        $data['login'] = $data['login']['id'];

        parent::editar($id, $data);

        $this->db->getConnection()->commit();
    }

    function buscar(int $id): array
    {
        $res = parent::buscar($id);

        $login = new LoginModel($this->ci);
        $res['login'] = $login->buscar($res['login']);
        
        return $res;
    }

}