<?php

namespace plugin\thread;

class Mysql implements Runnable {

    protected $query = [];
    protected $taskQueue;
    public $result;

    public function bindTo(PoolAdapter $class) {
        $this->taskQueue = $class;
    }

    public function run(): void {
        $result = [];

        while(!empty($this->query)) {
            $this->taskQueue->run(array_shift($this->query));
            $data = [];

            $res = $this->taskQueue->getResult();

            if( is_object($res) )
                while( ($row = $res->fetch_assoc()) ) 
                    $data[] = $row;

            $result[] = $data;
        }
            
        $this->result = json_encode($result);
    }

    public function recv(){
        $pool = new PoolController($this);
        $pool->start();
        $pool->join();
        return json_decode($pool->getResult());
    }

    public function setQuery(array $querys) : void {
        $this->query = $querys;
    }

    public function addQuery(string $query) : void {
        $this->query[] = $query;
    }
    

    public function getData(): string {
        return serialize($this);
    }

}

