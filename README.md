<h1>Laravel Enterprise Wechat</h1>

一个基于 `Laravel` 开发的企业微信 SDK
  
### 环境要求
- PHP >= 8.1
- Laravel >= 10

### 安装

###### 安装扩展包
```shell
composer require buqiu/enterprise_wechat
```
###### 发布迁移文件
```shell
php artisan vendor:publish --tag=enterprise_wechat-migrations
```

### 目录
- [环境要求](#环境要求)
- [安装](#安装)
- [账号管理](#账号管理)
- [账号连接切换](#账号的连接切换)
- [企微开发API](#企微开发API)
- [企业微信API](#企业微信API)

### 账号管理

为了方便维护企微账号的管理, 本扩展包提供了 `Artisan` 命令行方式管理企微账号。[文档参考](docs/Commands/README.md)


### 账号的连接切换

本扩展包提供了 `connect` 方法，用于动态连接切换企微账号, 连接切换方式有如下两种：

使用 `id` 连接切换
```php
EnterpriseWechatFacade::connect(id: 'id_xxx');
```
使用 `code` 连接切换
```php
EnterpriseWechatFacade::connect(code: 'tag_xxx');
```


### 企微开发API

> 对接使用此部分文档开发

企微开发主要是同步企微数据入库操作, 用于管理查询企微数据。

###### 前置条件

[账号连接切换](#账号的连接切换)

###### 使用示例

- [部门管理](docs/Libs/Department.md)
- [成员管理](docs/Libs/User.md)
- [标签管理](docs/Libs/Tag.md)
- [通讯录回调通知](docs/Libs/Callback.md)
- [身份认证](docs/Libs/Auth.md)
- [企业标签管理](docs/Libs/CorpTag.md)
- [客户管理](docs/Libs/Customer.md)
- [消息推送](docs/Libs/Message.md)
- [新客户欢迎](docs/Libs/Welcome.md)
- [群机器人](docs/Libs/Bot.md)
- [企业群发](docs/Libs/GroupMessage.md)
- [客户群管理](docs/Libs/GroupChat.md)
- [素材管理](docs/Libs/Media.md)
- [客户联系规则组管理](docs/Libs/Strategy.md)
- [朋友圈管理管理](docs/Libs/Moment.md)


### 企业微信API

在管理企微数据的同时，为了兼容企微的 `API`, 扩展包提供了 `api()` 方法，用于直接调用企微的 API 接口。

###### 前置条件

[账号连接切换](#账号的连接切换)

###### 使用示例

- [获取 `access_token`](docs/Api/AccessToken.md)
- [部门管理](docs/Api/Department.md)
- [成员管理](docs/Api/User.md)
- [标签管理](docs/Api/Tag.md)
- [通讯录回调通知](docs/Api/Callback.md)
- [身份认证](docs/Api/Auth.md)
- [企业标签管理](docs/Api/CorpTag.md)
- [客户管理](docs/Api/Customer.md)
- [消息推送](docs/Api/Message.md)
- [群机器人](docs/Api/Bot.md)
- [企业群发](docs/Api/GroupMessage.md)
- [客户群管理](docs/Api/GroupChat.md)
- [素材管理](docs/Api/Media.md)