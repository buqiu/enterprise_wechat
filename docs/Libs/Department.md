### 部门数据管理
```php
$department = EnterpriseWechatFacade::department();
```
---
### 同步所有部门数据
```php
# 是否使用事件[true:使用,false:不使用;默认为 true]
$department->syncList(bool '是否使用事件');  
```

### 同步单个部门数据
```php
$department->syncGet(int: '部门ID');
```

### 创建部门
```php
$department->create(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90205
```

### 更新部门
```php
$department->update(int: '部门ID', array: $data); # data :https://developer.work.weixin.qq.com/document/path/90206
```

### 删除部门
```php
$department->delete(int: '部门ID');
```
