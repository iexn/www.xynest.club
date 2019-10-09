<?php
namespace app\admin\controller;

class Nes extends Common
{

    public function index()
    {
        $this->setPageTitle('fc游戏管理');
        return $this->fetch('/nes/index');
    }

}