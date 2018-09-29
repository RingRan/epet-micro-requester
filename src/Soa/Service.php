<?php
namespace Epet\MicroRequest\Soa;

/**
 * Class Service
 *
 * SOA服务类
 *
 * @uses    Class for SOA services.
 *
 * @author  Speciallan
 * @version 1.0
 * @package web\soa
 */
class Service implements ServiceInterface
{
    /**
     * 服务id
     * 
     * @var string 
     */
    protected $id = '';

    /**
     * 服务名称
     * 
     * @var string 
     */
    protected $name = '';

    /**
     * 服务地址
     * 
     * @var string 
     */
    protected $address = '';

    /**
     * 服务端口
     * 
     * @var int 
     */
    protected $port = 0;

    /**
     * 服务标签
     * 
     * @var array
     */
    protected $tags = [];

    /**
     * 健康检查
     * 
     * @var array|mixed 
     */
    protected $check = [];

    /**
     * 服务节点
     * 
     * @var string
     */
    protected $node = '';

    /**
     * 节点ip
     * 
     * @var string 
     */
    protected $nodeAddress = '';

    /**
     * 是否重写
     * 
     * @var bool 
     */
    protected $enableTagOverride = false;
    
    /**
     * 创建时间
     * 
     * @var int
     */
    protected $createIndex = 0;

    /**
     * 修改时间
     * 
     * @var int 
     */
    protected $modifyIndex = 0;

    /**
     * Service constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->id      = $config['id']    ?? '';
        $this->name    = $config['name']  ?? '';
        $this->address = $config['addr']  ?? '';
        $this->port    = $config['port']  ?? '';
        $this->tags    = $config['tags']  ?? [];
        $this->check   = $config['check'] ?? [];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    /**
     * @return array|null
     */
    public function getTags()
    {
        $tags = empty($this->tags) ? [] : explode(',', $this->tags);
        return $tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function isEnableTagOverride(): bool
    {
        return $this->enableTagOverride;
    }

    /**
     * @param bool $enableTagOverride
     */
    public function setEnableTagOverride(bool $enableTagOverride): void
    {
        $this->enableTagOverride = $enableTagOverride;
    }

    /**
     * @return string
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param string $node
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * @return string
     */
    public function getNodeAddress()
    {
        return $this->nodeAddress;
    }

    /**
     * @param string $nodeAddress
     */
    public function setNodeAddress($nodeAddress)
    {
        $this->nodeAddress = $nodeAddress;
    }

    /**
     * @return array|mixed
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * @param array|mixed $check
     * @return Service
     */
    public function setCheck($check)
    {
        $this->check = $check;

        return $this;
    }
}
