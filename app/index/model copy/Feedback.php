<?php
namespace app\index\model;
use think\facade\Request;

class Feedback extends Common
{

    public function send($data = [])
    {
        $data = [
            'content' => $data['content'],
            'ip' => ip2long($_SERVER['REMOTE_ADDR']),
            'create_time' => Request::time()
        ];

        $result = $this->insert($data);

        return !empty($result);
    }

}