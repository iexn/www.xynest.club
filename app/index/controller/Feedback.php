<?php
namespace app\index\controller;
use think\facade\Request;
use app\index\model\Feedback AS FeedbackModel;

class Feedback extends Common
{

    public function index()
    {
        $this->setTitle('意见反馈');
        return $this->fetch('feedback/index');
    }

    public function send()
    {
        $params = Request::post();

        if(empty($params['content'])) {
            return '请填写内容';
        }

        $FeedbackModel = new FeedbackModel;

        $result = $FeedbackModel->send([
            'content' => $params['content']
        ]);

        if($result) {
            return '提交成功，<a href="/">点击返回首页</a>';
        }

        return '提交失败，，<a href="javascript:history.back()">点击返回编辑</a>';
    }

}