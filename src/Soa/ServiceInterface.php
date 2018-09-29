<?php
/**
 * MyClass Class Doc Comment
 *
 * @category Class
 * @package Epet\MicroRequest\Soa
 * @author   Ran Ping <ranping@gutou.com>
 * @license  http://www.epet.com.cn/
 * @link     http://www.epet.com.cn/
 */


namespace Epet\MicroRequest\Soa;

interface ServiceInterface
{
    /**
     * 得到服务地址
     *
     * @return string
     */
    public function getAddress();

    /**
     * 得到服务端口
     *
     * @return mixed
     */
    public function getPort();
}