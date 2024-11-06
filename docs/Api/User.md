
### 成员 `API` 调用
```php
$api = EnterpriseWechatFacade::user()->api();
```
---

### 获取成员ID列表
```php
$api->listId(cursor: 游标, limit: 分页);
```

### 获取部门成员详情
```php
$api->list(department_id: 部门ID);
```

### 创建成员
```php
$api->create(data: $data) # data: https://developer.work.weixin.qq.com/document/path/90195
```

### 更新成员
```php
$api->update(user_id: 部门ID, data: $data) # data: https://developer.work.weixin.qq.com/document/path/90197
```

### 读取成员
```php
$api->get(user_id: 成员UserID)
```
