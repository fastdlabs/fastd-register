<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2018
 *
 * @see      https://www.github.com/fastdlabs
 * @see      http://www.fastdlabs.com/
 */

namespace Registry\Storage;


/**
 * Interface RegistryStorageInterface
 * @package Registry\Storage
 */
interface RegistryStorageInterface
{
    /**
     * @param NodeInterface $node
     * @return NodeInterface
     */
    public function store(NodeInterface $node);

    /**
     * @param NodeInterface $node
     * @return NodeInterface
     */
    public function remove(NodeInterface $node);

    /**
     * @param $key
     * @return NodeInterface
     */
    public function fetch($key);
}