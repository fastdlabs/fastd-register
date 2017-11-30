<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Process;


use FastD\Process\AbstractProcess;
use Register\Node;
use swoole_process;

class Checkin extends AbstractProcess
{
    /**
     * @param swoole_process $swoole_process
     * @return callable|void
     */
    public function handle(swoole_process $swoole_process)
    {
        timer_tick(1000, function () {
            $nodes = Node::collection();
            $available = [];
            if (false !== $connections = server()->getSwoole()->connection_list()) {
                foreach ($connections as $connection) {
                    $available[] = $connection;
                }
                foreach ($nodes as $node) {
                    if (!isset($node['fd']) || !in_array($node['fd'], $available)) {
                        cache()->deleteItem('node.'.$node['name']);
                    }
                }
            }
        });
    }
}