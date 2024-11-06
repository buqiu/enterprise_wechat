### 群机器人 `API` 调用
```php
$api = EnterpriseWechatFacade::bot()->api();
```
---
### 发送消息
```php
$api->send(string: 'Key', array: $data); # data: https://developer.work.weixin.qq.com/document/path/99110
```
