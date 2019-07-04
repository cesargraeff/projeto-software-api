<?php

use Slim\App;
use Curriculo\Shared\Database;
use Curriculo\Shared\ErrorHandler;
use Curriculo\Shared\Logger;

return function (App $app) {
    
    $container = $app->getContainer();

    $container['db'] = function ($c) {
        $settings = $c->get('settings')['db'];
        return new Database($settings);
    };

    $container['logger'] = function($c){
        return new Logger();
    };

    $container['errorHandler'] = new ErrorHandler($container);

};
