<?php
namespace app\admin\model;
use app\common\Code;

class Admin extends Common
{

    public function getAdmin($username, $password)
    {
        $admin = $this->where([
            'username' => $username,
        ])->find();

        if(empty($admin)) {
            return Code::error(10001);
        }

        if($admin['password'] != sha1(sha1($password))) {
            return Code::error(10002);
        }

        if($admin['status'] != 'on') {
            return Code::error(10003);
        }

        return [
            'username' => $admin['username'],
            'partner'  => $admin['partner']
        ];
    }

}