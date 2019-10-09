<?php
namespace app\admin\controller;
use think\facade\Request;
use app\admin\model\Admin;
use think\facade\Cookie;
use app\common\Collection;
use app\common\Code;

class Login extends Common
{

    public function index()
    {
        return $this->fetch('/login');
    }

    public function signin()
    {
        $username = Request::post('username');
        $password = Request::post('password');
        $remember = Request::post('remember');

        $AdminModel = new Admin;
        $admin = $AdminModel->getAdmin($username, $password);
        if($admin === false) {
            return Collection::json();
        }

        $sign = encry([
            'username' => $admin['username'],
            'partner'  => $admin['partner'],
            'is_forever' => $remember == 'on'
        ]);

        Cookie::set('admin_sign', $sign, $remember == 'on' ? null : 1800);

        Code::success(90001);
        return Collection::json();
    }

    public function signout()
    {
        Cookie::delete();
        Session::clear();
        Code::success(90002);
        return Collection::json();
    }

}