### 企业标签 `API` 调用
```php
$api = EnterpriseWechatFacade::corpTag()->api();
```

---

### 获取企业标签库

```php
$api = $api->list(array '标签ID', array '标签组ID')
```

### 添加企业客户标签

```php
$api = $api->create(array $data) # data: https://developer.work.weixin.qq.com/document/path/92117
```

### 编辑企业客户标签

```php
$api = $api->update(array $data) # data: https://developer.work.weixin.qq.com/document/path/92117
```

### 删除企业客户标签

```php
$api = $api->delete(array '标签ID', array '标签组ID') 
```

