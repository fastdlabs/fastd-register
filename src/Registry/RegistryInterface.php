<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 12:32
 */

namespace Registry;


interface RegistryInterface
{
    const REGISTRY_PREFIX = 'fastd.registry.';

    /**
     * @param Node $node
     * @return Node
     */
    public function register(Node $node);

    /**
     * @param Node $node
     * @return mixed
     */
    public function unregister(Node $node);


    /**
     * 列出所有服务
     * @return array
     */
    public function list();

    /**
     * 列出服务所有节点详细信息
     * @param $service
     * @return array
     */
    public function show($service);
}