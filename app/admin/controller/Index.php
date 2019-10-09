<?php
namespace app\admin\controller;

class Index extends Common
{

    public function index()
    {
        $this->setPageTitle('首页');
        return $this->fetch('/index');
    }

}