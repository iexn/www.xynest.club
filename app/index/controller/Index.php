<?php
namespace app\index\controller;

class Index extends Common
{

    public function index()
    {
        return $this->fetch('/home');
    }

    public function exp()
    {
        return $this->fetch('/exp');
    }

}