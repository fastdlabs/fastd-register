<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2018
 *
 * @see      https://www.github.com/fastdlabs
 * @see      http://www.fastdlabs.com/
 */
namespace Provider;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Registry\Registry;

/**
 * Class RegisterProvider
 * @package Provider
 */
class RegisterProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container->add('registry', new Registry(config()->get('registry')));
    }
}
