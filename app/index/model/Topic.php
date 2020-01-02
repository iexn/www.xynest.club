<?php 
namespace app\index\model;

class Topic extends Common
{

    public function getList($condition = [])
    {

        $where = [
            'status' => 'on',
        ];

        if(!empty($condition['type'])) {
            $where['type'] = $condition['type'];
        }

        $order = [
            'sort' => 'DESC',
            'create_time' => 'DESC'
        ];

        return $this->where($where)->order($order)->select();

    }

    public function findRow($condition = [])
    {
        if(empty($condition)) {
            return false;
        }

        $where = [
            'status' => 'on'
        ];

        if(!empty($condition['id'])) {
            $where['id'] = $condition['id'];
        }

        return $this->where($where)->find();

    }

}