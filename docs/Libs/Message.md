### 消息推送管理
```php
$message = EnterpriseWechatFacade::message();
```
---
### 发送应用消息
```php
$message->send(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90236
```

### 撤回应用消息
```php
$message->recall(string: '消息ID');
```
