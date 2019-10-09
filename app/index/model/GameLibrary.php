<?php
namespace app\index\model;

class GameLibrary extends Common
{

    public function getList($condition = [])
    {
        $list = $this->getListCondition($condition)
                    ->where(['status'=>'on'])
                    ->order(['sort'=>'DESC', 'id'=>'DESC'])
                    ->paginate([
                        'list_rows' => 15,
                        'query' => [
                            'name' => $condition['name']
                        ]
                    ]);

        return $list;
    }

    protected function getListCondition($condition = [])
    {
        $where = [];

        if(!empty($condition['type'])) {
            if(!is_array($condition['type'])) {
                $condition['type'] = [$condition['type']];
            }
            $where[] = ['type', 'IN', 'nes,gba'];
        }
        if(!empty($condition['name'])) {
            $where[] = ['name', 'like', '%'.$condition['name'].'%'];
        }
        return $this->where($where);
    }

    public function findRow($condition = [])
    {
        $this->findRowCondition($condition);
        $row = $this->where([
            'id' => $condition['id']
        ])->find();

        if(empty($row)) {
            return [];
        }
        return $row->toArray();
    }

    protected function findRowCondition($condition)
    {
        $where = [
            'id' => $condition['id']
        ];
        $this->where($where);
    }

    public function getRankList()
    {
        $list = $this->where([
            'status' => 'on',
        ])
        ->order(['times'=>'DESC', 'id'=>'DESC'])
        ->limit(10)
        ->select();

        return $list;
    }

    public function getNewList()
    {
        $list = $this->where([
            'status' => 'on',
        ])
        ->order(['create_time'=>'DESC', 'id'=>'DESC'])
        ->limit(10)
        ->select();

        return $list;
    }

    public function stat_times($id)
    {
        $this->where(['id'=>$id])->save([
            'times' => ['inc', 1]
        ]);
    }

}