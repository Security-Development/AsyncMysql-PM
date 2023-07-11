<?php

namespace plugin;

use plugin\thread\job\Connect;
use plugin\thread\Mysql;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class AsyncMySQL extends PluginBase {
    use SingletonTrait;
    private static $mysql = null;

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->enablePlugin($this);
    }

    public static function connectToMySQL(string $host, string $username, string $password, string $database) {

        $mysql = new Mysql();
        $mysql->bindTo(new Connect($host, $username, $password, $database));
        self::$mysql = $mysql;
    }

    public static function execute(array $queries) {
        self::$mysql->setQuery($queries);
        return self::$mysql->recv();
    }

    public static function createDB(string $dbname) : void {
        if( is_null(self::$mysql) )
            throw new \Exception("The SQL connection is not registered");
        else
            self::execute(["CREATE DATABASE ".$dbname]);
    }

}
