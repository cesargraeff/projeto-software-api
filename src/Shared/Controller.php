<?php

namespace Curriculo\Shared;

use Interop\Container\ContainerInterface;


class Controller
{

    protected $ci;

    protected $model;

    public function __construct(ContainerInterface $ci, Model $model = null)
    {
        $this->ci = $ci;

        if($model){
            $this->model = new $model($ci);
        }
    }

}