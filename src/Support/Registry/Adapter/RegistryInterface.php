<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 12:32
 */

namespace Support\Registry\Adapter;


use Support\Registry\RegistryEntity;

interface RegistryInterface
{
    /**
     * 注册服务
     * @param RegistryEntity $entity
     */
    public function register(RegistryEntity $entity);


    /**
     * 移除服务
     * @param RegistryEntity $entity
     */
    public function deRegister(RegistryEntity $entity);


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