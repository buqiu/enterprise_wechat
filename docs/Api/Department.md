
### 部门 `API` 调用
```php
$api = EnterpriseWechatFacade::department()->api();
```
---

### 获取所有部门
```php
$api->list();
```

### 获取子部门ID列表
```php
$api->simpleList();
```

### 获取单个部门详情
```php
$api->get($id)
```

### 创建部门
```php
$api->create(data: $data) # data: https://developer.work.weixin.qq.com/document/path/90205
```

### 更新部门
```php
$api->update(id: 部门ID, data: $data) # data: https://developer.work.weixin.qq.com/document/path/90206
```

### 删除部门
```php
$api->delete(id: 部门ID)
```
