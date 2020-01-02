<?php 
namespace app\index\controller;

class Demo extends Common
{

    public function index()
    {
        $this->setTitle('示例');
        return $this->fetch('index');
    }

    public function demo1()
    {
        return $this->fetch('1');
    }
    
    public function demo2()
    {
        return $this->fetch('2');
    }
    
    public function demo3()
    {
        return $this->fetch('3');
    }

}