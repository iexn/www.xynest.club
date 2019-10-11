<?php
namespace app\admin\controller;
use app\BaseController;
use think\facade\View;
use think\facade\Config;
use think\facade\Session;
use app\common\Collection;

class Common extends BaseController
{
    protected $page_titles = [];

    public function initialize()
    {

        // 设置标题
        $this->setPageTitle(Config::get('app.title'));

        // 后台菜单
        $this->assign('menus', Config::get('app.menu'));

        // 设置后台标题
        $this->setPageTitle('后台管理平台');
    }

    protected function setPageTitle(string $name)
    {
        array_unshift($this->page_titles, $name);
    }

    protected function getPageTitle()
    {
        return implode(' - ', $this->page_titles);
    }

    protected function assign($name, $value = null)
    {
        return Collection::assign($name, $value);
    }

    protected function fetch($template, $vars = [])
    {
        $this->assign('page_title', $this->getPageTitle());
        $this->assign('admin_name', Session::get('admin.username'));
        $this->assign('admin_partner', Session::get('admin.partner'));
        return Collection::fetch($template, $vars);
    }

}