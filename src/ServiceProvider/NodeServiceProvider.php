<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace ServiceProvider;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Register\Node;

class NodeServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     * @return mixed
     */
    public function register(Container $container)
    {
        $container->add('node', new Node());
    }
}