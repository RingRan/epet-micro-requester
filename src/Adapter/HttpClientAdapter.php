<?php

namespace Epet\MicroRequest\Adapter;

/**
 * Class HttpClientAdapter
 *
 * @uses    Base adapter for all http clients.
 *
 * @author  Ring
 * @version 1.0
 * @package Epet\MicroRequest\Adapter
 */
abstract class HttpClientAdapter implements HttpClientAdapterInterface
{
    const SYNC        = 'curl';        //curl同步客户端

    /**
     * @var string 适配器名称
     */
    protected $adapterName = '';

    /**
     * @var mixed http客户端
     */
    protected $client = null;

    /**
     * @var string url
     */
    protected $url;

    /**
     * @var string 请求地址
     */
    protected $host;

    /**
     * @var int 请求端口
     */
    protected $port;

    /**
     * @var string 请求路径
     */
    protected $path;

    /**
     * @var int 超时时间
     */
    protected $timeout;

    /**
     * @var callable|null 异步回调
     */
    protected $callback = null;

    /**
     * @var string 协议
     */
    protected $protocol = 'http';

    /**
     * 设置数据
     *
     * @param $data
     * @return mixed
     */
    abstract function setData($data): void;

    /**
     * 设置header
     *
     * @param array $header
     * @return mixed
     */
    abstract function setHeader(array $header = []): void;

    /**
     * 执行请求
     *
     * @return mixed
     */
    abstract function execute();

    /**
     * 获取url
     *
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * 拼装url
     *
     * @return string
     */
    public function assembleUrl(): string
    {
        $this->url = $this->protocol . '://' . $this->host . ':' . $this->port . $this->path;

        return $this->url;
    }

    /**
     * 设置url
     *
     * @param $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
        $this->client->setUrl($url);
    }

    /**
     * 设置请求地址
     *
     * @param $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * 设置请求端口
     *
     * @param $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * 设置请求路径
     *
     * @param $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * 设置请求方法
     *
     * @param $method
     */
    public function setMethod(string $method): void
    {
        $this->client->setMethod($method);
    }

    /**
     * 设置超时时间
     *
     * @param int $timeout
     */
    public function setTimeout(int $timeout = 5): void
    {
        $this->timeout = $timeout;
    }

    /**
     * 设置请求回调
     *
     * @param callable $callback
     */
    public function setCallback(callable $callback): void
    {
        if (in_array($this->adapterName, [self::ASYNC, self::COROUTINE])) {

            $this->callback = $callback;
        } else {
            throw new \Epet\MicroRequest\Exception\RequestException('该Http客户端不支持callback');
        }
    }
}