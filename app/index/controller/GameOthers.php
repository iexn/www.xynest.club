<?php
namespace app\index\controller;

class GameOthers extends Common
{

    public function wzq()
    {
        $this->setTitle('h5五子棋');
        return $this->fetch('game/others/wzq');
    }

}