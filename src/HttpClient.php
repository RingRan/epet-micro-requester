<?php

namespace Epet\MicroRequest;

use Epet\MicroRequest\Adapter\HttpClientAdapter;
use Epet\MicroRequest\Exception\RequestException;

/**
 * Class HttpClient
 *
 * @uses    A http client.
 *
 * @author  Ring
 * @version 1.0
 * @package Epet\MicroRequest
 */
class HttpClient extends BaseObject implements HttpClientInterface
{
    /**
     * @var HttpClientAdapter
     */
    protected $adapter;

    /**
     * HttpClient constructor.
     *
     * @param string $host host
     * @param int $port post
     * @param string $adapter adapter
     * @throws RequestException
     */
    public function __construct($host = '', $port = 0, $adapter = HttpClientAdapter::SYNC)
    {
        if (is_object($adapter)) {
            if ($adapter instanceof HttpClientAdapter) {
                $this->adapter = $adapter;
                throw new RequestException('这里有点问题，待优化');
            } else {
                throw new RequestException('该对象不是Adapter');
            }
        } elseif (is_string($adapter)) {
            $class = '\\Epet\\MicroRequest\\Adapter\\' . ucfirst($adapter) . 'Adapter';
            if (class_exists($class)) {
                $this->adapter = new $class($host, $port);
            } else {
                throw new RequestException('该Http服务端适配器不存在');
            }
        }
    }

    /**
     * 设置请求url
     *
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->adapter->setUrl($url);
    }

    /**
     * 设置请求地址
     *
     * @param $host
     */
    public function setHost(string $host): void
    {
        $this->adapter->setHost($host);
    }

    /**
     * 设置请求路径
     *
     * @param $path
     */
    public function setPath(string $path): void
    {
        $this->adapter->setPath($path);
    }

    /**
     * 设置请求端口
     *
     * @param $port
     */
    public function setPort(int $port): void
    {
        $this->adapter->setPort($port);
    }

    /**
     * 设置超时时间
     *
     * @param $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->adapter->setTimeout($timeout);
    }

    /**
     * 设置请求方法
     *
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->adapter->setMethod($method);
    }

    /**
     * 设置header
     *
     * @param array $header
     */
    public function setHeader(array $header = []): void
    {
        $this->adapter->setHeader($header);
    }

    /**
     * 设置数据
     *
     * @param $data
     */
    public function setData($data): void
    {
        $this->adapter->setData($data);
    }

    /**
     * 设置请求回调
     *
     * @param callable $callback
     * @throws RequestException
     */
    public function setCallback(callable $callback)
    {
        $this->adapter->setCallback($callback);
    }

    /**
     * 执行请求
     *
     * @return mixed
     */
    public function execute()
    {
        //检验url
        if (empty($this->adapter->getUrl())) {
            $this->adapter->setUrl($this->adapter->assembleUrl());
        }

        return $this->adapter->execute();
    }

    /**
     * @param string $url
     * @param array $option
     * @param callable|null $callable
     * @return mixed
     * @throws RequestException
     */
    public function get(string $url, array $option = [], callable $callable = null)
    {
        $this->adapter->setPath($url);
        $this->adapter->setMethod(RequestMethod::GET);

        if (!empty($callable)) {
            $this->adapter->setCallback($callable);
        }

        return $this->adapter->execute();
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $option
     * @param callable|null $callable
     * @return mixed
     * @throws RequestException
     */
    public function post(string $url, array $data, array $option = [], callable $callable = null)
    {
        $this->adapter->setPath($url);
        $this->adapter->setMethod(RequestMethod::POST);
        $this->adapter->setData($data);

        if (!empty($callable)) {
            $this->adapter->setCallback($callable);
        }

        return $this->adapter->execute();
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $option
     * @param callable|null $callable
     * @return mixed
     * @throws RequestException
     */
    public function put(string $url, array $data, array $option = [], callable $callable = null)
    {
        $this->adapter->setPath($url);
        $this->adapter->setMethod(RequestMethod::PUT);
        $this->adapter->setData($data);

        if (!empty($callable)) {
            $this->adapter->setCallback($callable);
        }

        return $this->adapter->execute();
    }

    /**
     * delete
     *
     * @param string $url
     * @param array $data
     * @param array $option
     * @param callable|null $callable
     * @return mixed
     * @throws RequestException
     */
    public function delete(string $url, array $data, array $option = [], callable $callable = null)
    {
        $this->adapter->setPath($url);
        $this->adapter->setMethod(RequestMethod::DELETE);
        $this->adapter->setData($data);

        if (!empty($callable)) {
            $this->adapter->setCallback($callable);
        }

        return $this->adapter->execute();
    }
}
