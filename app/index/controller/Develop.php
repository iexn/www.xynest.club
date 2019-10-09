<?php 
namespace app\index\controller;

class Develop extends Common
{

    public function index()
    {
        $this->setTitle('网站推荐');
        return $this->fetch('develop/index');
    }

}