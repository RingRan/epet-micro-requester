<?php
namespace Epet\MicroRequest;

/**
 * 请求方式
 * Class RequestType
 * @package Epet\Http\Package
 */
class RequestType
{
    /**
     * @var string 表单
     */
    const FORM = 'form-data';

    /**
     * @var string 数据流
     */
    const RAW = 'raw-data';

    /**
     * @var string restful
     */
    const RESTFUL = 'restful';
}
