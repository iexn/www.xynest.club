<?php 
namespace app\user\controller;

class Login extends Common
{

    public function index()
    {
        return $this->fetch('/login');
    }
    
}