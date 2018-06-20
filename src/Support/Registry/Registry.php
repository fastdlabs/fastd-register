<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 16:08
 */

namespace Support\Registry;


use Support\Registry\Adapter\RegistryInterface;

class Registry implements RegistryInterface
{
    /**
     * @var RegistryInterface
     */
    protected  $registry;

    public function __construct()
    {
        $registry_config = config()->get('registry_server');

        if (!isset($registry_config['driver'])) {
            return false;
        }

        $driver = ucfirst($registry_config['driver']);

        $registry_namespace = "Support\\Registry\\Adapter\\{$driver}Registry";

        if (!class_exists($registry_namespace)) {
            return false;
        }

        $this->registry = new $registry_namespace($registry_config);
    }

    /**
     * @param RegistryEntity $entity
     */
    public function register(RegistryEntity $entity)
    {
        $this->registry->register($entity);
    }

    /**
     * @param RegistryEntity $entity
     */
    public function deRegister(RegistryEntity $entity)
    {
        $this->registry->deRegister($entity);
    }

    /**
     * @return array
     */
    public function list()
    {
        return $this->registry->list();
    }

    /**
     * @param $service
     * @return array
     */
    public function show($service)
    {
        return $this->registry->show($service);
    }
}