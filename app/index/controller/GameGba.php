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

}