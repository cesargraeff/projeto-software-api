<?php

namespace Curriculo\Exception;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'O registro não foi encontrado';
}