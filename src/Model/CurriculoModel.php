<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class CurriculoModel extends Model
{

    protected $table = 'curriculos';

    protected $fillable = [
        'curso_id',
        'codigo',
        'nome',
    ];

    protected $validators = [
        'curso_id' => 'required|numeric',
        'codigo' => 'required|max:10',
        'nome' => 'required|min:3|max:100'
    ];

    public function visualizar(int $aluno)
    {

        $db = $this->db->getConnection()->prepare('
            SELECT
                d.id,
                d.codigo,
                d.nome,
                d.semestre,
                d.nota_minima,
                m.id AS matricula,
                m.nota,
                m.semestre AS semestre_cursado
            FROM 
                alunos AS a
            INNER JOIN disciplinas AS d ON  a.curriculo_id = d.curriculo_id
            LEFT JOIN matriculas AS m ON m.aluno_id = a.id and m.disciplina_id = d.id
            WHERE a.id = ?;
        ');
        $db->execute(array($aluno));

        $res = $db->fetchAll();

        $requisitos = new RequisitoModel($this->ci);
        foreach($res as $key => $value){
            $res[$key]['requisitos'] = $requisitos->listarPorDisciplina($value['id']);
        }

        return $res;
        
    }

}