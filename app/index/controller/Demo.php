<?php 
namespace app\index\controller;

class Demo extends Common
{

    public function demo1()
    {
        return $this->fetch('1');
    }
    public function demo2()
    {
        return $this->fetch('2');
    }

}