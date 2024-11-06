### 企业群发
```php
$api = EnterpriseWechatFacade::groupChat()->api();
```
---
### 获取客户群列表
```php
$api->list(array: $data); # data: https://developer.work.weixin.qq.com/document/path/92120
```

### 获取客户群详情
```php
$api->get(string: '客户群ID', int: '是否需要返回群成员的名字, 默认不返回');
```

### 客户群opengid转换
```php
$api->opengIdToChatId(string: "小程序在微信获取到的群ID");
```
