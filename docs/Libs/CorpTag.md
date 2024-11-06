### 企业标签数据管理
```php
$corpTag = EnterpriseWechatFacade::corpTag();
```
---

### 同步企业标签数据
```php
$corpTag->syncList()
```

### 新建企业标签
```php
$corpTag->create(array $data) # data: https://developer.work.weixin.qq.com/document/path/92117
```

### 更新企业标签
```php
$corpTag->update(array $data) # data: https://developer.work.weixin.qq.com/document/path/92117
```

### 编辑客户企业标签
```php
$corpTag->mark(array $data) # data: https://developer.work.weixin.qq.com/document/path/92118
```

### 删除企业标签
```php
$corpTag->delete(array '标签id列表', array '标签组id列表') 
```
