<?php

namespace plugin;

use mysqli_sql_exception;
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
        if( is_null(self::$mysql) )
            throw new \Exception("The SQL connection is not registered");
        else
            self::$mysql->setQuery($queries);
        return self::$mysql->recv();
    }

    public static function createTable(string $tablename, array $columns) {
        $query = "CREATE TABLE IF NOT EXISTS $tablename (";
        $columnList = [];

        foreach ($columns as $columnName => $columnType)
            $columnList[] = "`$columnName` $columnType";

        $query .= implode(', ', $columnList);
        $query .= ")";

        self::execute([$query]);

    }

    public static function createDB(string $dbname) : void {
        self::execute(["CREATE DATABASE ".$dbname]);
    }

}
