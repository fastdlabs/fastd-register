# FastD Registry

FastD Registry 是PHP的服务化框架的服务发现-注册中心，独立与框架与其他依赖，可以自由整合到 fastd 中，以 provider 的方式进行服务提供。

使用 zookeeper 和 redis 作为服务发现驱动

> 引用一个图

![](https://github.com/weibocom/motan/wiki/media/14612349319195.jpg)

* Server提供服务，向Registry注册自身服务，并向注册中心定期发送心跳汇报状态；
* Client使用服务，需要向注册中心订阅RPC服务，Client根据Registry返回的服务列表，与具体的Sever建立连接，并进行RPC调用。
* 当Server发生变更时，Registry会同步变更，Client感知后会对本地的服务列表作相应调整。

> FastD 本身就是一个Server，对外提供服务

原理: 

启动注册中心，监听上报端口与查询端口，接受所有服务器上报的数据状态，等待接入。

FastD 可以通过添加 [register-provider](https://github.com/fastdlabs/register-provider) 扩展，让服务在启动的时候，自动向注册中心添加服务信息。

通过 [sentinel](https://github.com/fastdlabs/sentinel) 可以及时发现有哪些服务可用，然后在客户端就可以更好地使用服务，甚至进行监控告警等。

## 使用(待补充)

### Support

如果你在使用中遇到问题，请联系: [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com). 微博: [编码侠](http://weibo.com/ecbboyjan)

## License MIT