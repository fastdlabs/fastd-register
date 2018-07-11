<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2018
 *
 * @see      https://www.github.com/fastdlabs
 * @see      http://www.fastdlabs.com/
 */

namespace Registry\Contracts;

/**
 * Interface StorageInterface
 * @package Registry\Contracts
 */
interface StorageInterface
{
    const PREFIX = 'fastd.registry.';
    /**
     * @param NodeAbstract $node
     * @return NodeAbstract
     */
    public function store(NodeAbstract $node);

    /**
     * @param NodeAbstract $node
     * @return boolean
     */
    public function remove(NodeAbstract $node);

    /**
     * @param $key
     * @return array
     */
    public function fetch($key);

    /**
     * @return array
     */
    public function all();
}
