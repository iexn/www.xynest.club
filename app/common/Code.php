<?php
namespace app\common;

class Code
{

    private static $code = [
        '10001' => '用户不存在',
        '10002' => '密码错误，登录失败',
        '10003' => '账号已禁用，登录失败',
        '90001' => '登录成功',
        '90002' => '退出成功',
    ];

    public static function error($code)
    {
        self::collection($code, self::$code[$code]);
        return false;
    }

    public static function success($code)
    {
        self::collection($code, self::$code[$code]);
        return true;
    }

    private static function collection($code, $message)
    {
        Collection::setCode($code);
        Collection::setTitle($message ?: '未知错误');
    }

}