<?php
namespace app\index\model;

class SearchLog extends Common
{

    public function recode($search, $type)
    {

        $log = $this->field('id')->where([
            'search' => $search,
            'type' => $type
        ])->find();

        if(!empty($log)) {
            $this->where(['id'=>$log['id']])->save([
                'times' => ['inc', 1]
            ]);
        } else {
            $this->save([
                'search' => $search,
                'type' => $type,
                'create_time' => time()
            ]);
        }

    }

}