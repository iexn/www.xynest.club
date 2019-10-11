<?php 

/**
 * 获取fc游戏排行榜
 */
function data_fc_rank()
{
    static $list = [];
    if(empty($list)) {
        $GameLibrary = new \app\index\model\GameLibrary;
        $list = $GameLibrary->getRankList();
    }
    return $list;
}

/**
 * 获取fc游戏最新添加
 */
function data_fc_new()
{
    static $list = [];
    if(empty($list)) {
        $GameLibrary = new \app\index\model\GameLibrary;
        $list = $GameLibrary->getNewList();
    }
    return $list;
}