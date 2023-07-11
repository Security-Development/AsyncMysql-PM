<?php

namespace plugin;

use pocketmine\plugin\PluginBase;

class example extends PluginBase {
    public function onEnable() : void{
        $this->getServer()->getPluginManager()->enablePlugin($this);
        AsyncMySQL::connectToMySQL('localhost', 'root', 'pw', 'mysql');

        $queries = [
            "SHOW PROCESSLIST;",
            "SHOW TABLES;"
        ];

        $result = AsyncMySQL::execute($queries);
        var_dump($result);
    }
}