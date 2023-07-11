<?php

namespace plugin\thread;

interface Runnable {
    
    public function bindTo(PoolAdapter $class);
    public function run(): void;

}