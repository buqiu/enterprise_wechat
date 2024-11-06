### 客户数据管理
```php
$customer = EnterpriseWechatFacade::customer();
```
---

### 同步成员客户列表
```php
$customer->syncList();
```

### 修改客户备注信息
```php
$customer->remark(array $data) # data: https://developer.work.weixin.qq.com/document/path/92118
```

### 分配在职成员的客户
```php
$customer->transferCustomer(array $data) # data: https://developer.work.weixin.qq.com/document/path/92125
```

### 分配离职成员的客户
```php
$customer->resignedTransferCustomer(array $data) # data: https://developer.work.weixin.qq.com/document/path/94081
```

### 查询客户接替状态(在职)
```php
$customer->transferResult(string:'原添加成员ID', string:'接替成员ID')
```

### 查询客户接替状态(在职)-分页
```php
['分页查询的cursor', '数据'] = $customer->transferResultPage(string:'原添加成员ID', string:'接替成员ID', string: "分页查询的cursor")
```

### 查询客户接替状态(离职)
```php
$customer->resignedTransferResult(string:'原添加成员ID', string:'接替成员ID')
```
### 查询客户接替状态(离职)-分页
```php
['分页查询的cursor', '数据'] = $customer->resignedTransferResultPage(string:'原添加成员ID', string:'接替成员ID', string: "分页查询的cursor")
```