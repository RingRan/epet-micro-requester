<?php

namespace Epet\MicroRequest\Adapter;

use Epet\MicroRequest\Curl;

/**
 * Class CurlAdapter
 *
 * @uses    Adapter for curl http client.
 *
 * @author  Ring
 * @version 1.0
 * @package Epet\MicroRequest\Adapter
 */
class CurlAdapter extends HttpClientAdapter
{
    /**
     * @var string 适配器名称
     */
    protected $adapterName = HttpClientAdapter::SYNC;

    /**
     * @var Curl|null
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
     * @var string 协议
     */
    protected $protocol = 'http';

    /**
     * CurlAdapter constructor.
     *
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $this->client = new Curl();
        $this->host   = $host;
        $this->port   = $port;
    }

    /**
     * 设置请求path
     *
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
        $this->client->setUrl($this->assembleUrl());
    }

    /**
     * 设置header
     *
     * @param array $header
     */
    public function setHeader(array $header = []): void
    {
        $this->client->setHeader($header);
    }


    /**
     * 设置数据
     */
    public function setData($data): void
    {
        $this->client->setPostFields($data);
    }

    /**
     * 执行请求
     *
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        $response = $this->client->exec();

        $this->client->close();

        return $response;
    }
}
