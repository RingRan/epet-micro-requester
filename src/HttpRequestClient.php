<?php

namespace Epet\MicroRequest;
use \Epet\MicroRequest\Exception\RequestException;

/**
 * Class HttpRequestClient
 *
 * @uses    A http request client.
 *
 * @author  Ring
 * @version 1.0
 * @package Epet\MicroRequest
 */
class HttpRequestClient
{
    /**
     * @var Adapter\HttpClientAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var string
     */
    protected $defaultUserAgent = '';

    /**
     * HttpRequestClient constructor.
     */
    public function __construct()
    {
    }


    /**
     * 执行请求
     *
     * @param BaseRequest $request
     * @param int $timeout
     * @return BaseResponse
     * @throws Exception\RequestException
     */
    public function execute(BaseRequest $request, $timeout = 5)
    {
        //参数验证
        $params = $this->verify($request);
        $this->assemble($request, $params);

        $client = new HttpClient($request->getServiceHost(), $request->getServicePort());
        $client->setMethod($request->getRequestMethod());
        $client->setUrl($request->getRequestUrl());
        $client->setTimeout($timeout);
        $client->setHeader([
            'Connection' => 'Keep-Alive',
            'Keep-Alive' => '120'
        ]);
        if ($request->getRequestMethod() != RequestMethod::GET) {
            if ($request->getRequestType() == RequestType::RAW) {
                $params = json_encode($params); //如果是raw data方式提交，则直接赋值json
            }
            $client->setData($params);
        }

        $json        = $client->execute();
        $rawResponse = json_decode($json);

        return $this->createResponse($rawResponse);
    }

    /**
     * 参数验证
     *
     * @param BaseRequest $request
     * @return array|null
     * @throws Exception\RequestException
     */
    protected function verify(BaseRequest $request): ?array
    {
        $params = $request->getRequestParams();

        foreach ($params as $k => $v) {
            if ($v == RequestParam::REQUIRED) {
                throw new RequestException('请求参数不完整!');
            } elseif ($v == RequestParam::OPTIONAL) {
                unset($params[$k]);
            }
        }

        return $params;
    }

    /**
     * 路由组装
     *
     * @param BaseRequest $request
     * @param array       $params
     */
    protected function assemble(BaseRequest $request, array $params): void
    {
        $path = $request->getServicePath();

        foreach ($params as $k => $v) {
            // 如果参数值是数组，则在url拼接时转为json
            if (is_array($v)) {
                $v = json_encode($v);
            }
            $path = str_replace('{' . $k . '}', $v, $path);
        }

        if ($request->getRequestMethod() == RequestMethod::GET) {
            $path .= '?' . http_build_query($params);
        }

        $request->setServicePath($path);
    }

    /**
     * 生成响应对象
     *
     * @param $rawResponse
     * @return BaseResponse
     */
    protected function createResponse($rawResponse): BaseResponse
    {
        $response = new BaseResponse();
        $response->setStatusCode(intval($rawResponse->status_code));
        $response->setMessage($rawResponse->message);
        $response->setData($rawResponse->data);
        $response->setMeta($rawResponse->meta);
        $response->setErrors($rawResponse->errors);

        return $response;
    }

}
