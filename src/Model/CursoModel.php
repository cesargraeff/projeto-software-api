<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class CursoModel extends Model
{

    protected $table = 'cursos';

    protected $fillable = [
        'codigo',
        'nome',
        'duracao'
    ];

    protected $validators = [
        'codigo' => 'required|max:10',
        'nome' => 'required|min:3|max:100',
        'duracao' => 'required|numeric'
    ];

}