<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 14:28
 */

namespace Support\Registry;


class RegistryEntity
{
    /**
     * 服务名称
     * @var string
     */
    protected $service = 'demo';

    /**
     * 节点，服务的一个实例
     * @var string
     */
    protected $node;

    /**
     * 服务进程pid
     * @var string
     */
    protected $pid;

    /**
     * 服务地址
     * @var string
     */
    protected $host = '0.0.0.0';

    /**
     * 服务端口
     * @var string
     */
    protected $prot = '9527';

    /**
     * 服务注册
     * @var string
     */
    protected $regtime;

    /**
     * 服务其他拓展信息
     * @var string
     */
    protected $extend;

    public function __construct(array $entity)
    {
        $url = parse_url($entity['service_host']);

        $this->setService($entity['service_name'])
            ->setHost($url['host'])
            ->setPort($url['port'])
            ->setPid($entity['service_pid'])
            ->setNode()
            ->setExtend($entity['extend'] ?? '')
            ->setRegtime();
    }

    /**
     * @param $service
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param $pid
     * @return $this
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }
    /**
     * @param $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->prot = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->prot;
    }

    /**
     * @return $this
     */
    public function setNode()
    {
        $this->node = md5($this->service . $this->host . $this->prot);

        return $this;
    }

    /**
     * @return string
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return $this
     */
    public function setRegtime()
    {
        $this->regtime = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * @return string
     */
    public function getRegtime()
    {
        return $this->regtime;
    }

    /**
     * @param $extend
     * @return $this
     */
    public function setExtend($extend)
    {
        if (is_array($extend)) {
            $extend = json_encode($extend);
        }
        $this->extend = $extend;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtend()
    {
        return $this->extend;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'service' => $this->getService(),
            'node' => $this->getNode(),
            'pid' => $this->getPid(),
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'regtime' => $this->getRegtime(),
            'extend' => $this->getExtend()
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}