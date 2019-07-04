<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class RequisitoModel extends Model
{

    protected $table = 'requisitos';

    const PREREQUISITO = 'P';
    const COREQUISITO = 'C';

    protected $fillable = [
        'disciplina',
        'disciplina_requisito',
        'tipo'
    ];

    protected $validators = [
        'disciplina' => 'required|numeric',
        'disciplina_requisito' => 'required|numeric',
        'tipo' => 'required|in:P,C'
    ];

    
    public function listarPorDisciplina(int $disciplina){

        $db = $this->db->getConnection()->prepare('
            SELECT 
                r.disciplina_requisito AS disciplina,
                d.codigo,
                r.tipo
            FROM '.$this->table.' AS r
            INNER JOIN disciplinas AS d ON d.id = r.disciplina_requisito
            WHERE disciplina = ?');
        $db->execute(array($disciplina));

        return $db->fetchAll();
    }

}