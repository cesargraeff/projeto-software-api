<?php

namespace Curriculo\Shared;

use PDO;

class Database
{

    private $settings;

    private $connection;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    public function getConnection()
    {

        if (!$this->connection) {

            $this->connection = new PDO(
                'mysql:host='.$this->settings['host'].';dbname='.$this->settings['database'].'; charset=UTF8', 
                $this->settings['user'], 
                $this->settings['pass']
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        }
        
        return $this->connection;
    }

}
