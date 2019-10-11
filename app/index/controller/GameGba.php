<?php
namespace app\index\controller;

class GameGba extends Common
{

    public function start()
    {
        $this->assign('title', '恶魔城-月下轮舞曲');
        $this->assign('path', 'https://cdn.xynest.club/game/roms/gba/恶魔城-月下轮舞曲.gba');
        return $this->fetch('game/engine/gba');

    }

    public function test()
    {
        $this->setTitle('恶魔城－晓月之圆舞曲');
        $this->assign('game_name', '恶魔城－晓月之圆舞曲');
        $this->assign('game_path', 'https://cdn.xynest.club/game/roms/gba/%E6%81%B6%E9%AD%94%E5%9F%8E%EF%BC%8D%E6%99%93%E6%9C%88%E4%B9%8B%E5%9C%86%E8%88%9E%E6%9B%B2.gba');
        return $this->fetch('game/engine/gba_2');

    }

}