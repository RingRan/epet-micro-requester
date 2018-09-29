<?php

namespace Epet\MicroRequest;

/**
 * Class BaseObject
 *
 * eFrame 全对象基类
 *
 * 实现单例
 * 请在对应实例化单例类中使用SingletonTrait
 *
 * @uses    Base class for all objects.
 *
 * @author  Speciallan
 * @version 1.0
 * @package Epet\Base
 */
abstract class BaseObject
{
    /**
     * 容器对象
     *
     * @var Container
     */
    private static $_container = null;

    /**
     * 获取单例对象
     *
     * @return static
     */
    public static function init()
    {
        if (!isset(self::$_container) || empty(self::$_container)) {

            self::$_container = App::$container;
        }

        $key = static::class;

        if (!self::$_container->has($key)) {

            self::$_container->set($key, new static());
        }

        return self::$_container->get($key);
    }

    /**
     * BaseObject constructor.
     */
    protected function __construct()
    {

    }

    /**
     * 新实例
     *
     * @return static
     */
    public static function newInstance()
    {
        return new static();
    }
}

