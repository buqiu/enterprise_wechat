### 消息 `API` 调用
```php
$api = EnterpriseWechatFacade::message()->api();
```
---
### 发送应用消息
```php
$api->send(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90236
```
### 撤回应用消息
```php
$api->recall(string: '消息ID');
```
