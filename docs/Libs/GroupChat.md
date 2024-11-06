### 企业群发
```php
$chat = EnterpriseWechatFacade::groupChat();
```
---
### 同步客户群
```php
$chat->syncList();
```
### 同步客户群详情
```php
$chat->syncGet(string: 群ID);
```

### 客户群`opengid`转换
```php
$groupMessage->opengIdToChatId(string: "小程序在微信获取到的群ID");
```
### 分配在职成员的客户群
```php
$groupMessage->onJobTransfer(string: '新群主ID', array: '群列表');
```
### 分配离职成员的客户群
```php
$groupMessage->resignedTransfer(string: '新群主ID', array: '群列表');
```
