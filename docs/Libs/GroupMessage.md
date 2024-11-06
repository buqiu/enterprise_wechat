### 企业群发
```php
$groupMessage = EnterpriseWechatFacade::groupMessage();
```
---
### 发送消息
```php
$groupMessage->send(array: $data); # data: https://developer.work.weixin.qq.com/document/path/92135
```

### 提醒消息
```php
$groupMessage->remind(string: "消息ID");
```

### 取消消息
```php
$groupMessage->cancel(string: "消息ID");
```
