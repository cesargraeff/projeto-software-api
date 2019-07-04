<?php

namespace Curriculo\Shared;

use Interop\Container\ContainerInterface;
use Rakit\Validation\Validator;
use Curriculo\Exception\ValidationException;

class Model
{

    protected $ci;

    protected $db;

    protected $log;

    protected $usuario;

    protected $settings;

    protected $table;

    protected $fillable = [];

    protected $validators = [];

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->db = $ci->get('db');
        $this->log = $ci->get('logger');
        $this->settings = $ci->get('settings');

    }

    /**
     * Adiciona novo registro
     *
     * @param array $data
     * @return int
     */
    public function adicionar(array $data): int
    {
        $data = $this->validate($data);

        $columns = '`'.implode('`=?, `', array_keys($data)).'`=?';
        $values = array_values($data);

        $db = $this->db->getConnection()->prepare('INSERT INTO '.$this->table.' SET '.$columns);
        $db->execute($values);

        return $this->db->getConnection()->lastInsertId();
    }


    /**
     * Realiza a edição
     *
     * @param integer $id
     * @param array $data
     * @return void
     */
    public function editar(int $id, array $data)
    {
        $data = $this->validate($data);

        $columns = '`'.implode('`=?, `', array_keys($data)).'`=?';
        $values = array_values($data);
        $values[] = $id;

        $db = $this->db->getConnection()->prepare('UPDATE '.$this->table.' SET '.$columns.' WHERE id = ?');
        $db->execute($values);
    }


    /**
     * Realiza a busca
     *
     * @param integer $id
     * @return array
     * 
     * @throws NotFoundException
     */
    public function buscar(int $id) : array
    {
        $db = $this->db->getConnection()->prepare('SELECT * FROM '.$this->table.' WHERE id = ? LIMIT 1');
        $db->execute(array($id));

        if($db->rowCount() == 0){
            throw new NotFoundException('Registro não encontrado');
        }

        return $db->fetch();
    }


    /**
     * Realiza a listagem
     *
     * @return array
     */
    public function listar(): array
    {
        $db = $this->db->getConnection()->prepare('SELECT * FROM '.$this->table);
        $db->execute();

        return $db->fetchAll();
    }


    /**
     * Realiza a exclusão
     *
     * @param int $id
     * @return void
     */
    public function deletar(int $id)
    {
        $db = $this->db->getConnection()->prepare('DELETE FROM '.$this->table.' WHERE id = ?');
        $db->execute(array($id));
    }

    
    /**
     * Remove campos não editaveis
     * Realiza a validação do campos
     *
     * @param array $data
     * @return array
     */
    protected function validate(array $data): array
    {
        foreach($data as $key => $value){
            if(!in_array($key, $this->fillable)){
                unset($data[$key]);
            }
        }

        $validator = new Validator();
        $validation = $validator->make($data, $this->validators);
        $validation->validate();

        if($validation->fails()){
            throw new ValidationException($validation->errors()->toArray());
        }

        return $data;
    }

}