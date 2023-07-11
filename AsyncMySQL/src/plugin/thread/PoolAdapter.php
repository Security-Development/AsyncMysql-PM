<?php
namespace plugin\thread;

interface PoolAdapter {

    public function run(string $qeury) : void;
    
}