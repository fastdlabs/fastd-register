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
 * Interface NodeInterface
 * @package Registry\Storage
 */
interface NodeInterface
{
    /**
     * @return string
     */
    public function hash();

    /**
     * @return string
     */
    public function service();
    /**
     * @return string
     */
    public function pid();

    /**
     * @return string
     */
    public function host();

    /**
     * @return string
     */
    public function port();

    /**
     * @return string
     */
    public function extra();

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return array
     */
    public function toArray();
}
