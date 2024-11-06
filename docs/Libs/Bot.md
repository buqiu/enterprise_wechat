### 群机器人 `API` 调用
```php
$bot = EnterpriseWechatFacade::bot();
```
---
### 发送消息
```php
$bot->send(string: 'Key', array: $data); # data: https://developer.work.weixin.qq.com/document/path/99110
```
