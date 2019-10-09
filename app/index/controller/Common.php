<?php
namespace app\index\controller;
use app\BaseController;
use think\facade\Config;
use think\facade\View;

class Common extends BaseController
{

    private $title = [];

    public function initialize()
    {
        $title = Config::get('app.app_title');
        if(!empty($title)) {
            $this->title[] = $title;
        }
    }

    protected function setTitle($title = '')
    {
        if(!empty($title)) {
            $this->title[] = $title;
        }
        return $this;
    }

    protected function assign($name, $value = null)
    {
        View::assign($name, $value);
        return $this;
    }

    protected function fetch($template = '', $vars = [])
    {
        $title = $this->title;
        $this->assign('title', implode(' - ', array_reverse($title)));
        array_shift($title);
        $this->assign('bar', implode(' / ', $title));
        return View::fetch($template, $vars);
    }

}