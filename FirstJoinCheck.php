<?php

namespace plugin;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class example extends PluginBase implements Listener {

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        AsyncMySQL::connectToMySQL('localhost', 'root', 'lee12345', 'test');
        AsyncMySQL::createTable("player_connect", [
            'username' => 'VARCHAR(255)'
        ]);
    }

    public function check_player($username) {
        $result = AsyncMySQL::execute(['SELECT username FROM player_connect WHERE username="'.$username.'"']);
        return !empty($result[0]);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $check = $this->check_player($player->getName());
        
        if( $check ){
            $player->sendMessage("안녕하세요.");
        } else {
            $player->sendMessage("처음 오시는 유저님 환영합니다.");
            AsyncMySQL::execute(['INSERT INTO player_connect (username) VALUES ("'.$player->getName().'")']);
        }
    }

} 
