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
        'municipio'
    ];

}