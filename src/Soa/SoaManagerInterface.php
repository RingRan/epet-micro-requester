<?php
/**
 * MyClass Class Doc Comment
 *
 * @category Class
 * @author   Ran Ping <ranping@gutou.com>
 * @license  http://www.epet.com.cn/
 * @link     http://www.epet.com.cn/
 */
namespace Epet\MicroRequest\Soa;

interface SoaManagerInterface
{
    /**
     * 返回服务信息
     *
     * @return ServiceInterface
     */
    public function discovery() : ServiceInterface;
}
