### 客户联系规则组管理
```php
$strategy = EnterpriseWechatFacade::strategy();
```
---

### 同步规则组
```php
$strategy->syncList();
```

### 新建规则组
```php
$strategy->create(array: $data); # data: https://developer.work.weixin.qq.com/document/path/94883
```

### 修改规则组
```php
$strategy->update(array: $data); # data: https://developer.work.weixin.qq.com/document/path/94883
```

### 删除规则组
```php
$strategy->delete(int: '规则组ID');
```
