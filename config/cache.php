<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'default' => [
        'adapter' => \Symfony\Component\Cache\Adapter\RedisAdapter::class,
        'params' => [
            'dsn' => qconf_get_value(
                '/conf/services/register/redis/cache/dsn',
                null,
                null,
                'redis://127.0.0.1:6397/15'
            )
        ],
    ]
];
