<?php

namespace plugin\thread\job;

use mysqli;
use plugin\thread\PoolAdapter;

class Connect implements PoolAdapter {
    
    protected  $hostname;
    protected  $username;
    protected  $password;
    protected  $database;
    protected  $port;
    protected $result;
    protected static $mysql;

    public function __construct($hostname, $username, $password, $database, $port = 3306)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port     = $port;
    }   

    protected function getConnection() {
        if (!self::$mysql) {
            self::$mysql = new mysqli(
                $this->hostname, 
                $this->username, 
                $this->password, 
                $this->database, 
                $this->port);
        } 
         
        return self::$mysql;
    }

    public function run(string $query): void {
        $mysql = $this->getConnection();
        $this->result = $mysql->query($query);
    }

    public function getResult() {
        return $this->result;
    }

}