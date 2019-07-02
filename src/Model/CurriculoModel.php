<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class CurriculoModel extends Model
{

    protected $table = 'curriculos';


    public function visualizar(int $aluno, int $curriculo){

        $db = $this->db->prepare('');
        $db->execute(array());
        
    }

}