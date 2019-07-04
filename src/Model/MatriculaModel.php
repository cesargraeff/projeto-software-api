<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;
use Slim\Handlers\Error;
use Curriculo\Exception\ValidationException;

class MatriculaModel extends Model
{

    protected $table = 'matriculas';

    protected $fillable = [
        'disciplina_id',
        'aluno_id',
        'semestre',
        'nota'
    ];

    protected $validators = [
        'disciplina_id' => 'required|numeric',
        'aluno_id' => 'required|numeric',
        'semestre' => 'required|numeric',
        'nota' => 'numeric'
    ];

    public function adicionar(array $data): int
    {
        $this->validate($data);

        $db = $this->db->getConnection()->prepare('SELECT * FROM requisitos WHERE disciplina = ?');
        $db->execute(array($data['disciplina_id']));

        foreach($db->fetchAll() as $requisito){

            $db = $this->db->getConnection()->prepare('
                SELECT 
                    m.*,
                    d.nota_minima
                FROM matriculas AS m
                INNER JOIN disciplinas AS d ON d.id = m.disciplina_id
                WHERE m.aluno_id = ? and m.disciplina_id = ?
            ');
            $db->execute(array($data['aluno_id'],$requisito['disciplina_requisito']));

            if($db->rowCount() == 0){
                throw new ValidationException([
                    'requisito' => [
                        'required' => 'Existem requisitos não cumpridos para a disciplina'
                    ]
                ]);
            }else{
                if($requisito['tipo'] == RequisitoModel::PREREQUISITO){
                    $matricula = $db->fetch();
                    if((float)$matricula['nota_minima'] > (float)$matricula['nota']){
                        throw new ValidationException([
                            'requisito' => [
                                'required' => 'Existem requisitos não cumpridos para a disciplina'
                            ]
                        ]);
                    }
                }
            }
        }

        return parent::adicionar($data);
    }

}