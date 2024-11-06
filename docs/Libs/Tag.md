### 标签数据管理
```php
$tag = EnterpriseWechatFacade::tag();
```
---
### 同步所有标签
```php
$tag->syncList(bool '同步类型');  # 同步类型[true:为强制同步,false:增量更新同步;默认为 false]
```

### 新建标签
```php
$tag->create(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90210
```

### 修改标签
```php
$tag->update(int: '标签ID', string: '标签名称');
```

### 删除标签
```php
$tag->delete(int: '标签ID');
```

### 同步标签成员
```php
$tag->syncUserTagList(int: '标签ID', array: '用户列表', array: '部门列表');
```

### 添加标签成员
```php
$tag->addTagUsers(int: '标签ID', array: '用户列表', array: '部门列表');
```

### 删除标签成员
```php
$tag->delTagUsers(int: '标签ID', array: '用户列表', array: '部门列表');
```
