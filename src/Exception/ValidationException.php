<?php

namespace Curriculo\Exception;

use Exception;

class ValidationException extends Exception
{
    protected $message = 'Ocorreram erros na validação das informações';

    protected $errors = [];

    public function __construct(array $errors) {
        $this->errors = $errors;
    }

    public function getErrors(){
        return $this->errors;
    }
}