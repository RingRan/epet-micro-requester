<?php

namespace Epet\MicroRequest;

/**
 * Class BaseResponse
 *
 * 基础响应对象
 *
 * @uses    Base class for responses.
 *
 * @author  Speciallan
 * @version 1.0
 * @package Epet\Base\Standard
 */
class BaseResponse
{
    use RequestTrait;

    /**
     * @var int 响应状态码
     */
    protected $statusCode = 0;

    /**
     * @var string 响应消息
     */
    protected $message = '';

    /**
     * @var string 响应数据
     */
    protected $data = '';

    /**
     * @var string 响应元数据
     */
    protected $meta = '';

    /**
     * @var string 响应错误
     */
    protected $errors = '';

    /**
     * 获取响应数据
     *
     * @return mixed
     */
    public function getData($format = 'json')
    {
        if('json' == $format) {
            return json_encode($this->data);
        }
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param mixed $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getResponseDto()
    {
        return $this->responseDto;
    }

    /**
     * @param string $responseDto
     */
    public function setResponseDto($responseDto)
    {
        $this->responseDto = $responseDto;
    }

    /**
     * @return string
     */
    public function getResponseDtoList()
    {
        return $this->responseDtoList;
    }

    /**
     * @param string $responseDtoList
     */
    public function setResponseDtoList($responseDtoList)
    {
        $this->responseDtoList = $responseDtoList;
    }
}
