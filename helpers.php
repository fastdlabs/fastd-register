<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

/**
 * 节点操作
 *
 * @return \Register\Node
 */
function node()
{
    return app()->get('node');
}