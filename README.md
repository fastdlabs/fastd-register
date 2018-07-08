# FastD Registry

FastD Registry 是PHP的服务化框架的服务发现-注册中心，独立与框架与其他依赖，可以自由整合到 fastd 中，以 provider 的方式进行服务提供。

使用 zookeeper 和 redis 作为服务发现驱动

> 引用一个图

![](https://github.com/weibocom/motan/wiki/media/14612349319195.jpg)

## 使用

在 `config\config.php` 中添加 register_server

### Redis
```php
<?php
return [
    'registry_server' => [
        'driver' => 'redis',
        'options' => [
            'host' => '10.0.75.1',
            'port' => 6379,
            'auth' => '',   
        ],
    ],
];
    
```

### Zookeeper
```php
<?php
return  [
    'registry_server' => [
        'driver' => 'redis',
        'options' => [
            'host' => '10.0.75.1',
            'port' => 6379,
            'auth' => '',   
        ],
    ],
];
    
```
## 拓展

生产者-消费者模式支持tcp广播

* 在`config\server.php` 中添加

```php
<?php
return [
    'listeners' => [
        [
            'host' => '0.0.0.0:9996',
            'class' => \Server\ProducerTcpServer::class
        ]
    ]
];
```

* 在`config\config.php` 中添加

```php
<?php
return [
    'producer_server' => [
        'host' => 'tcp://0.0.0.0:9996'
    ]
];
 ```


### Support

如果你在使用中遇到问题，请联系: [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com). 微博: [编码侠](http://weibo.com/ecbboyjan)

## License MIT