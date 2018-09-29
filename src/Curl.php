<?php

namespace Epet\MicroRequest;

use Epet\MicroRequest\Exception\RequestException;
use Exception;
use Closure;

/**
 * Class Curl
 *
 * @uses    A http client.
 *
 * @author  Ring <ranping@gutou.com>
 * @version 1.0
 * @package Epet\MicroRequest
 */
class Curl
{
    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    /**
     * 连接超时时间
     *
     * @var int
     */
    public $connectTimeout = 10;

    /**
     * 读取超时时间
     *
     * @var int
     */
    public $readTimeout = 10;

    /**
     * resource a cURL handle
     */
    protected $_curlHandle;

    /**
     * CURL信息
     */
    protected $_curlInfo;

    public static $curlHandle;

    /**
     * Curl constructor.
     */
    public function __construct()
    {
        self::$curlHandle = curl_init();
    }

    /**
     * 设置请求地址
     *
     * @param string $url 请求地址
     * @return static
     */
    public function setUrl($url)
    {
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt(self::$curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt(self::$curlHandle, CURLOPT_SSL_VERIFYHOST, false);
        }

        curl_setopt(self::$curlHandle, CURLOPT_URL, $url);

        return $this;
    }

    /**
     * 设置请求头
     *
     * @param array $header 请求头
     * @return static
     */
    public function setHeader($header = [])
    {
        curl_setopt(self::$curlHandle, CURLOPT_HTTPHEADER, $header);

        return $this;
    }

    /**
     * 设置请求参数
     *
     * @param Closure $closure 匿名函数
     * @return static
     */
    public function set(Closure $closure)
    {
        call_user_func_array($closure, [self::$curlHandle]);

        return $this;
    }

    /**
     * 设置方法
     *
     * @param string $method 方法
     * @return static
     */
    public function setMethod($method = 'GET')
    {
        switch ($method) {
            case 'POST':
                curl_setopt(self::$curlHandle, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt(self::$curlHandle, CURLOPT_POST, 1);
                break;

            case 'PUT':

                curl_setopt(self::$curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;

            case 'DELETE':

                curl_setopt(self::$curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            case 'GET':
                curl_setopt(self::$curlHandle, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt(self::$curlHandle, CURLOPT_HTTPGET, true);
                break;
        }

        return $this;
    }

    /**
     * 设置post请求数据
     *
     * @param mixed $postFields 请求数据
     * @return static
     */
    public function setPostFields($postFields)
    {
        if ($postFields) {
            if ($postFields instanceof Closure) {
                $this->set($postFields);
            } else {
                $data = is_array($postFields) ? http_build_query($postFields) : $postFields;

                curl_setopt(self::$curlHandle, CURLOPT_POSTFIELDS, $data);
            }
        }

        return $this;
    }

    /**
     * 发起查询
     *
     * @return mixed
     * @throws Exception
     */
    public function exec()
    {
        curl_setopt(self::$curlHandle, CURLOPT_FAILONERROR, false);
        curl_setopt(self::$curlHandle, CURLOPT_RETURNTRANSFER, true);

        if ($this->readTimeout) {
            curl_setopt(self::$curlHandle, CURLOPT_TIMEOUT, $this->readTimeout);
        }

        if ($this->connectTimeout) {
            curl_setopt(self::$curlHandle, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        $response = curl_exec(self::$curlHandle);

        $this->_curlInfo = curl_getinfo(self::$curlHandle);

        if (curl_errno(self::$curlHandle)) {
            throw new RequestException(curl_error(self::$curlHandle), 0);
        }

        return $response;
    }

    /**
     * 关闭句柄
     */
    public function close()
    {
        //curl_close($this->_curlHandle);
    }

    /**
     * 获取最近一次请求的信息
     *
     * @return mixed
     */
    public function getLastCurlInfo()
    {
        return $this->_curlInfo;
    }

    /**
     * 获取Curl
     *
     * @return resource
     */
    public function getCurlHandle()
    {
        return self::$curlHandle;
    }
}
