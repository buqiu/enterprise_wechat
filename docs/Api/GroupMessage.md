### 企业群发
```php
$api = EnterpriseWechatFacade::groupMessage()->api();
```
---
### 发送消息
```php
$api->send(array: $data); # data: https://developer.work.weixin.qq.com/document/path/92135
```
### 提醒消息
```php
$api->remind(string: "消息ID");
```

### 取消消息
```php
$api->cancel(string: "消息ID");
```
