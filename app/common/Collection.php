<?php
namespace app\common;
use think\facade\View;

/**
 * 收集数据，最后决定输出模板还是输出接口
 */
class Collection
{
    private static $collection = [];

    private static $code  = 0;
    private static $title = '';

    public static function assign($name, $value = '')
    {
        self::$collection[$name] = $value;

        return new self;
    }

    public static function setTitle($title)
    {
        self::$title = $title;

        return new self;
    }

    public static function setCode($code)
    {
        self::$code = $code;

        return new self;
    }


    public static function fetch($template, $vars = [])
    {
        View::assign(self::$collection);
        return View::fetch($template, $vars);
    }

    public static function json()
    {
        return json([
            'data'    => self::$collection,
            'message' => self::$title,
            'code'    => self::$code
        ]);
    }

}