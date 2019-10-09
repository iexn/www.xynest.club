<?php
namespace app\index\controller;
use think\facade\Request;
use app\index\model\GameLibrary;
use app\index\model\SearchLog;

class GameFc extends Common
{
    
    public function initialize()
    {
        parent::initialize();
        $this->setTitle('FC游戏');
    }

    /**
     * 游戏列表
     */
    public function index()
    {
        $request = Request::instance();

        $name = $request->get('name');
        $page = $request->get('page');

        $GameLibrary = new GameLibrary;
        $games = $GameLibrary->getList([
            'type' => ['nes'],
            'name' => $name
        ]);
        
        if(!empty($name) && $page == NULL) {
            $SearchLog = new SearchLog;
            $SearchLog->recode($name, 'nes');
            
        }

        $rank = $GameLibrary->getRankList();
        $new = $GameLibrary->getNewList();

        $this->assign('games', $games);
        $this->assign('rank', $rank);
        $this->assign('new', $new);
        return $this->fetch('fc/index');
    }

    public function start()
    {
        $request = Request::instance();

        $game_id = $request->param('id');

        $GameLibrary = new GameLibrary;
        $game = $GameLibrary->findRow([
            'id' => $game_id
        ]);

        if(empty($game)) {
            exit('游戏未记录');
        }

        if($game['type'] != 'nes') {
            exit('游戏读取失败');
        }
        
        $this->setTitle($game['name']);
        $this->assign('game_title', $game['name']);
        $this->assign('game_id', $game_id);
        $this->assign('game_path', 'https://cdn.xynest.club/game' . $game['path']);

        return $this->fetch('game/engine/nes');
    }

    public function stat_times()
    {
        $request = Request::instance();
        $game_id = $request->param('id');

        $GameLibrary = new GameLibrary;
        $GameLibrary->stat_times($game_id);
    }

}