<?php
namespace app\admin\middleware;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\Request;

class AdminAuth
{
    public function handle($request, \Closure $next)
    {
        // 添加中间件执行代码
        $admin = $this->validateAdmin();
        if($admin !== true) {
            return $admin;
        }

        return $next($request);
    }

    public function validateAdmin()
    {
        $instance = Request::instance();

        // Login.php排除
        if($instance->app() == 'admin' && $instance->controller() == 'Login') {
            return true;
        }

        $sign = Cookie::get('admin_sign');
        if(empty($sign)) {
            // 会话已过期，请重新登录
            return redirect('Login/index')->remember();
        }

        $admin = decry($sign);

        if(empty($admin)) {
            // 会话已过期，请重新登录
            return redirect('Login/index')->remember();
        }

        Session::set('admin', $admin);

        // 记住登录状态
        if($admin['is_forever']) {
            return true;
        } else {
            // 半小时有效期
            Cookie::set('admin_sign', $sign, 1800);
        }

    }
}