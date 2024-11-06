### 客户 `API` 调用
```php
$api = EnterpriseWechatFacade::customer()->api();
```

---

### 获取客户列表

```php
$api = $api->list(string '用户ID')
```

### 获取客户详情

```php
$api = $api->get(string '客户ID', ?string '游标')
```

### 批量获取客户详情

```php
$api = $api->batchGetByUser(array '客户ID', ?string '游标', ?int '最大记录数')
```

### 修改客户备注信息

```php
$api = $api->remark(array $data) # data: https://developer.work.weixin.qq.com/document/path/92115
```
