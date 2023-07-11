<?php

namespace plugin;

use plugin\thread\job\Connect;
use plugin\thread\Mysql;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class AsyncMySQL extends PluginBase {
    use SingletonTrait;
    private static $mysql;

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->enablePlugin($this);

        /*

        $mysql = new Mysql();
        $mysql->bindTo(new Connect("localhost", "root", "lee12345", "mysql"));

        $mysql->setQuery(["SHOW PROCESSLIST;"]);
        $result = $mysql->recv();
        //var_dump($result);

        $mysql->setQuery(["SHOW TABLES;", "SHOW TABLES;"]);
        $result = $mysql->recv();
        var_dump($result[0][0]->Tables_in_mysql);
        echo $result[0][0]->Tables_in_mysql."\n";
        */
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

}
