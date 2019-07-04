<?php

namespace Curriculo\Model;

use Curriculo\Shared\Model;

class LoginModel extends Model
{

    protected $table = 'login';

    protected $fillable = [
        'email',
        'senha'
    ];

    protected $validators = [
        'email' => 'required:email|min:3|max:100',
        'senha' => 'required'
    ];

}