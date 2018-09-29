<?php

use \Epet\MicroRequest\RequestMethod;
use \Epet\MicroRequest\BaseRequest;
use \Epet\MicroRequest\RequestParam;

class TestRequester extends BaseRequest
{
    /**
     * @var string 服务名称
     */
    protected $serviceName = 'php-server-common';

    /**
     * @var string 请求地址（通过服务发现获取）
     */
    protected $serviceHost = '';

    /**
     * @var int 请求端口（通过服务发现获取）
     */
    protected $servicePort = 0;

    /**
     * @var string 服务版本
     */
    protected $serviceVersion = 'v1';

    /**
     * @var string 服务应用路径
     */
    protected $servicePath = '/auth/issue';

    /*
     * @var string 服务应用路由
     */
    protected $serviceRoute = '';

    /**
     * @var string 请求方法
     */
    protected $requestMethod = RequestMethod::GET;

    /**
     * @var array 请求参数
     */
    protected $requestParams = [
        'username' => RequestParam::REQUIRED,
        'pwd' => RequestParam::REQUIRED, //用户编号
    ];


    /**
     *
     * @param string $uid
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     *
     * @param string $uid
     */
    public function setPwd(string $pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     *
     * @param string $uid
     */
    public function setExp(string $exp)
    {
        $this->exp = $exp;
    }
}


