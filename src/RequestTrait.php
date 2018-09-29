<?php

namespace Epet\MicroRequest;

/**
 * Class RequestTrait
 *
 * 基础请求对象Trait
 *
 * @uses    Trait for requests.
 *
 * @author  Ring <ranpng@gutou.com>
 * @version 1.0
 * @package Epet\Base\Standard
 */
trait RequestTrait
{
    /**
     * @var array 响应体
     */
    protected $response;

    /**
     * @var string 是否返回DTO响应
     */
    protected $responseDto = '';

    /**
     * @var string 返回DTO列表
     */
    protected $responseDtoList = '';

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getResponseDto()
    {
        return $this->responseDto;
    }

    /**
     * @return string
     */
    public function getResponseDtoList()
    {
        return $this->responseDtoList;
    }
}
