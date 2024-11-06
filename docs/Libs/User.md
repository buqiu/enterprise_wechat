### 成员数据管理
```php
$user = EnterpriseWechatFacade::user();
```
---

### 同步部门成员详情
```php
# 是否使用事件[true:使用,false:不使用;默认为 true]
$user->syncList(bool '是否使用事件');  
```

### 同步部门离职成员
```php
# 是否使用事件[true:使用,false:不使用;默认为 true]
$user->syncResignList(bool '是否使用事件');  
```

### 同步单个部门成员详情
```php
$user->syncDepartmentUser(int: '部门ID')
```

### 同步单个成员详情
```php
$user->syncGet(int: '部门ID')
```

### 创建成员
```php
$user->create(array $data) # data: https://developer.work.weixin.qq.com/document/path/90195
```

### 更新成员
```php
$user->update(string: '成员ID', array $data) # data: https://developer.work.weixin.qq.com/document/path/90197
```

### 删除成员
```php
$user->delete(string: '成员ID')
```

### 批量删除成员
```php
$user->batchDelete(array: '成员ID');
```

### 同步启用了客户联系功能的成员
```php
$user->syncFollowUserList();
```
