<?php 
namespace app\index\controller;

use think\facade\Request;
use app\index\model\Topic;

class GameTopic extends Common
{

    public function index()
    {
        $Topic = new Topic;

        $list = $Topic->getList([
            'type' => 'game'
        ]);

        $this->assign('list', $list);
        return $this->fetch('index');
    }

    public function detail()
    {

        $request = Request::instance();
        $id = $request->param('id');

        $Topic = new Topic;
        $topic = $Topic->findRow([
            'id' => $id
        ]);

        $this->assign('topic', $topic);
        return $this->fetch('detail');
    }

}