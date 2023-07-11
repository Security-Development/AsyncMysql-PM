<?php

namespace plugin\thread;

use pocketmine\thread\Thread;

class PoolController extends Thread {

    protected $thread;
    protected $result;

    public function __construct(Mysql $task) {
        $this->thread = $task->getData();
    }

    public function onRun() : void {
        $task = unserialize($this->thread);
        $task->run();
        $this->result = $task->result;
    }

    public function getResult() {
        return $this->result;
    }
    
}