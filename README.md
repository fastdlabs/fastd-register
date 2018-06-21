# FastD Registry

注册中心

## 注册中心配置
在`config\config.php`中添加register_server,当前支持Redis、Zookeeper

### Redis
```
    'registry_server' => [
        'driver' => 'redis',
        'host' => '10.0.75.1',
        'port' => 6379,
        'auth' => '',
    ],
```

### Zookeeper
```
    'registry_server' => [
        'driver' => 'zookeeper',
        'host' => '127.0.0.1',
        'port' => 2181,
        //集群模式
        //'url' => '127.0.0.1:2181,127.0.0.1:2182'
    ],
```
## 拓展

生产者-消费者模式支持tcp广播

* 在`config\server.php` 中添加

```
    'listeners' => [
        [
            'host' => '0.0.0.0:9996',
            'class' => \Server\ProducerTcpServer::class
        ]
    ]，
```

* 在`config\config.php` 中添加

  ```
    'producer_server' => [
        'host' => 'tcp://0.0.0.0:9996'
      ]
  ```


### Support

如果你在使用中遇到问题，请联系: [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com). 微博: [编码侠](http://weibo.com/ecbboyjan)

## License MIT