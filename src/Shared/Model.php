<?php

namespace Curriculo\Shared;

use Interop\Container\ContainerInterface;


class Model
{

    protected $ci;

    protected $db;

    protected $log;

    protected $usuario;

    protected $settings;

    protected $table;

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
        $columns = '`'.implode('`=?, `', array_keys($data)).'`=?';
        $values = array_values($data);

        $db = $this->db->prepare('INSERT INTO '.$this->table.' SET '.$columns);
        $db->execute($values);

        return $this->db->lastInsertId();
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
        $columns = '`'.implode('`=?, `', array_keys($data)).'`=?';
        $values = array_values($data);
        $values[] = $id;

        $db = $this->db->prepare('UPDATE '.$this->table.' SET '.$columns.' WHERE id = ?');
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
        $db = $this->db->prepare('SELECT * FROM '.$this->table.' WHERE id = ? LIMIT 1');
        $db->execute(array($id));

        if($db->rowCount() == 0){
            throw new NotFoundException('Categoria não encontrada');
        }

        return $db->fetch();
    }


    /**
     * Realiza a listagem
     *
     * @param array $params
     * @return array
     */
    public function listar(): array
    {
        $db = $this->db->prepare('SELECT * FROM '.$this->table);
        $db->execute(array());

        return $db->fetch();
    }

}