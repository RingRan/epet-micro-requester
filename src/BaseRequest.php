<?php

namespace Epet\MicroRequest;

use Epet\MicroRequest\Exception\RequestException;
use Epet\MicroRequest\Soa\Manager;
use Epet\MicroRequest\Soa\ManagerInterface;
use Epet\MicroRequest\Soa\ServiceInterface;
use Epet\MicroRequest\Soa\SoaManagerInterface;

/**
 * Class BaseRequest
 *
 * 基础请求对象
 *
 * @uses    Base class for requests.
 *
 * @author  Ring
 * @version 1.0
 * @package Epet\Base\Standard
 */
class BaseRequest
{
    use RequestTrait;

    /**
     * @var SoaManagerInterface $soaManager
     */
    protected $soaManager = null;

    /**
     * @var string 服务名称
     */
    protected $serviceName    = '';
    
    /**
     * @var string 请求地址（默认通过服务发现获取，也可以设置）
     */
    protected $serviceHost    = '';
    
    /**
     * @var int 请求端口（默认通过服务发现获取，也可以设置）
     */
    protected $servicePort    = 0;

    /**
     * @var string 服务版本
     */
    protected $serviceVersion = '';

    /**
     * @var string 服务应用路径
     */
    protected $servicePath    = '';

    /**
     * @var string 服务应用路由
     */
    protected $serviceRoute   = '';

    /**
     * @var string 请求方法
     */
    protected $requestMethod = RequestMethod::GET;

    /**
     * @var array 请求参数
     */
    protected $requestParams  = [];

    /**
     * @var string uri
     */
    protected $requestUri     = '';

    /**
     * @var string token
     */
    protected $requestToken   = '';

    /**
     * @var string 请求类型
     */
    protected $requestType    = RequestType::FORM;

    protected $redis = null;

    protected $consulHttpAddress = '';

    /**
     * @var string refer service name
     */
    protected $referServiceName = '';

    /**
     * @return string
     */
    public function getReferServiceName(): string
    {
        return $this->referServiceName;
    }

    /**
     * @param string $referServiceName
     */
    public function setReferServiceName(string $referServiceName)
    {
        $this->referServiceName = $referServiceName;
    }

    /**
     * @return string
     */
    public function getReferRequestHost(): string
    {
        return $this->referRequestHost;
    }

    /**
     * @param string $referRequestHost
     */
    public function setReferRequestHost(string $referRequestHost)
    {
        $this->referRequestHost = $referRequestHost;
    }

    /**
     * @return string
     */
    public function getGatewayTrace(): string
    {
        return $this->GatewayTrace;
    }

    /**
     * @param string $GatewayTrace
     */
    public function setGatewayTrace(string $GatewayTrace)
    {
        $this->GatewayTrace = $GatewayTrace;
    }

    /**
     * @var string request host
     */
    protected $referRequestHost = '';

    /**
     * @var string refer trace_id
     */
    protected $GatewayTrace = '';

    /**
     * @return string
     */
    public function getConsulHttpAddress(): string
    {
        return $this->consulHttpAddress;
    }

    /**
     * @param string $consulHttpAddress
     */
    public function setConsulHttpAddress(string $consulHttpAddress)
    {
        $this->consulHttpAddress = $consulHttpAddress;
    }

    /**
     * @return null
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @param null $redis
     */
    public function setRedis($redis)
    {
        $this->redis = $redis;
    }


    public function __construct()
    {
    }

    /**
     * 发送服务请求
     *
     * @return BaseRequest
     */
    public function send(): BaseRequest
    {
        //准备服务地址
        $this->prepareServiceAddress();

        //执行请求
        $client         = new HttpRequestClient();
        $this->response = $client->execute($this);

        return $this;
    }

    /**
     * 准备服务地址
     */
    protected function prepareServiceAddress()
    {
        if (!empty($this->serviceHost) && !empty($this->servicePort)) {
            $this->setServiceHost($this->serviceHost);
            $this->setServicePort($this->servicePort);
        } else {
            //走服务发现
            $this->serviceDiscovery();
        }
    }

    /**
     * 服务发现获取服务ip端口
     *
     * @throws RequestException
     */
    protected function serviceDiscovery(): void
    {
        if(empty($this->soaManager)) {
            if('' == $this->getServiceName()) {
                throw new RequestException("服务名不能为空");
            }

            $this->soaManager = new Manager($this->redis, $this->getConsulHttpAddress());
        }

        $server = $this->soaManager->discovery($this->getServiceName());
        if(!$server instanceof ServiceInterface) {
            throw new RequestException("服务不存在");
        }

        $this->setServiceHost($server->getAddress());
        $this->setServicePort($server->getPort());
    }

    public function setSoaManager(SoaManagerInterface $soaManager) {
        $this->soaManager = $soaManager;
    }

    /**
     * 获取响应
     *
     * @return BaseResponse
     */
    public function getResponse(): BaseResponse
    {
        return $this->response;
    }

    /**
     * 获取服务名称
     *
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * set服务名称
     *
     * @return string
     */
    public function setServiceName(string $serviceName)
    {
        return $this->serviceName = $serviceName;
    }

    /**
     * 获取请求方法
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * 获取Uri
     *
     * @return string
     */
    public function getRequestUri(): string
    {
        $this->requestUri = '/' . $this->serviceVersion . $this->servicePath . $this->serviceRoute;
        return $this->requestUri;
    }

    /**
     * 获取请求地址
     *
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->serviceHost . ':' . $this->servicePort . $this->getRequestUri();
    }

    /**
     * 获取请求参数
     *
     * @return array
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * 获取服务地址
     *
     * @return string
     */
    public function getServiceHost(): string
    {
        return $this->serviceHost;
    }

    /**
     * 获取请求类型
     *
     * @return string
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * 设置服务地址
     *
     * @param string $serviceHost
     */
    public function setServiceHost($serviceHost)
    {
        $this->serviceHost = $serviceHost;
    }

    /**
     * 获取服务端口
     *
     * @return int
     */
    public function getServicePort(): int
    {
        return $this->servicePort;
    }

    /**
     * 设置服务端口
     *
     * @param int $servicePort
     */
    public function setServicePort($servicePort)
    {
        $this->servicePort = intval($servicePort);
    }

    /**
     * 获取服务路径
     *
     * @return string
     */
    public function getServicePath(): string
    {
        return $this->servicePath;
    }

    /**
     * set service verwsion
     *
     * @param $serviceVersion
     */
    public function setServiceVersion($serviceVersion) {
        $this->serviceVersion = $serviceVersion;
    }

    /**
     * 设置服务路径
     *
     * @param $servicePath
     */
    public function setServicePath($servicePath)
    {
        $this->servicePath = $servicePath;
    }

    /**
     * 设置请求参数
     *
     * @param $key
     * @param $value
     */
    public function setRequestParam($key, $value)
    {
        $this->requestParams[$key] = $value;
    }

    /**
     * 设置服务应用路由
     *
     * @param string $serviceRoute
     */
    public function setServiceRoute($serviceRoute)
    {
        $this->serviceRoute = $serviceRoute;
    }

    /**
     * 设置请求类型
     *
     * @param string $requestType
     */
    public function setRequestType(string $requestType)
    {
        $this->requestType = $requestType;
    }

    /**
     * 获取属性值
     *
     * @param string $name 名称
     * @return mixed|null
     */
    public function __get($name)
    {
        if (isset($this->requestParams[$name])) {
            return $this->requestParams[$name];
        }

        return null;
    }

    /**
     * 设置属性
     *
     * @param string $name 名称
     * @param string $value 值
     */
    public function __set($name, $value)
    {
        $this->set($this->requestParams, $name, $value);
    }

    /**
     * 是否有属性
     *
     * @param string $name 名称
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->{$name}) || isset($this->_items[$name]);
    }


    public function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}
