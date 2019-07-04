<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class DisciplinaModel extends Model
{

    protected $table = 'disciplinas';

    protected $fillable = [
        'codigo',
        'nome',
        'semestre',
        'nota_minima',
        'curriculo_id',
    ];

    protected $validators = [
        'codigo' => 'required|max:10',
        'nome' => 'required|min:3|max:100',
        'semestre' => 'required|numeric',
        'nota_minima' => 'required|numeric',
        'curriculo_id' => 'required|numeric'
    ];

}