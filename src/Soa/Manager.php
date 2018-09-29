<?php

namespace Epet\MicroRequest\Soa;

use Epet\MicroRequest\Exception\RequestException;
use Epet\MicroRequest\HttpClient;

/**
 * Class Manager
 *
 * SOA管理者
 *
 * @uses    Manager of service governance.
 *
 * @author  Speciallan
 * @version 1.0
 * @package web\soa
 */
class Manager implements SoaManagerInterface
{
    protected $redis = null;

    protected $consul_http_address = '';

    protected $cacheTime = 10;

    protected $redisKey  = 'service_discovery';

    /**
     * Manager constructor.
     */
    public function __construct($redis, $consul_http_address)
    {
        $this->redis = $redis;
        $this->consul_http_address = $consul_http_address;
    }

    /**
     * 服务发现
     *
     * @param string $serviceName
     * @return ServiceInterface
     * @throws \Exception
     */
    public function discovery($serviceName = ''): ServiceInterface
    {
        if (empty($serviceName)) {
            throw new RequestException('服务名不能为空');
        }

        if (!empty($this->redis)) {
            $hash      = $this->redis->hash();

            //服务缓存
            if ($hash->hexists($this->redisKey, $serviceName)) {
                $serviceJson = $hash->hget($this->redisKey, $serviceName);
                $serviceInfo = json_decode($serviceJson, true);

                $returnInfo = new Service();

                //节点信息
                $nodeArr = $serviceInfo['Node'];
                $returnInfo->setNode($nodeArr['Node'] ?? '');
                $returnInfo->setNodeAddress($nodeArr['Address'] ?? '');

                //服务信息
                $serviceInfo = $serviceInfo['Service'];
                $returnInfo->setId($serviceInfo['ID']);
                $returnInfo->setName($serviceInfo['Service']);
                $returnInfo->setAddress($serviceInfo['Address']);
                $returnInfo->setPort($serviceInfo['Port']);
                $returnInfo->setTags($serviceInfo['Tags']);

                return $returnInfo;
            }
        }

        //请求服务中心
        $client = new HttpClient();
        $client->setMethod('get');
        $client->setUrl($this->consul_http_address . '/v1/health/service/' . $serviceName);
        $json        = $client->execute();
        $healthArr = json_decode($json, true);

        if (!empty($healthArr)) {
            foreach ($healthArr as $k => $v) {
                $checks = $v['Checks'];
                $check  = $checks[0] ?? [];

                if ($check['Status'] != 'passing') {
                    unset($healthArr[$k]);
                }
            }
        }

        //客户端负载均衡
        $health = !empty($healthArr) ? $healthArr[array_rand($healthArr, 1)] : null;

        $service = $health;

        $returnInfo = new Service();

        //封装返回服务信息
        if (!empty($service)) {

            //节点信息
            $nodeArr = $service['Node'];
            $returnInfo->setNode($nodeArr['Node'] ?? '');
            $returnInfo->setNodeAddress($nodeArr['Address'] ?? '');

            //服务信息
            $serviceInfo = $service['Service'];
            $returnInfo->setId($serviceInfo['ID']);
            $returnInfo->setName($serviceInfo['Service']);
            $returnInfo->setAddress($serviceInfo['Address']);
            $returnInfo->setPort($serviceInfo['Port']);
            $returnInfo->setTags($serviceInfo['Tags']);

            //健康检查信息

            //写服务缓存
            if($this->redis) {
                $this->redis->hash()->hset($this->redisKey, $serviceName, json_encode($service), $this->cacheTime);
            }
        }

        return $returnInfo;
    }
}
