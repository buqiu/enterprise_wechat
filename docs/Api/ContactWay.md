### 客户联系「联系我」 `API` 调用
```php
$api = EnterpriseWechatFacade::contactWay()->api();
```

---

### 配置客户联系「联系我」方式

```php
$api = $api->create(data: $data)
```

### 获取企业已配置的「联系我」方式

```php
$api = $api->show(string: '配置ID')
```

### 获取企业已配置的「联系我」列表

```php
$api = $api->list(?int: '开始时间', ?int: '结束时间', ?string: '游标', ?int: '最大记录数')
```

### 更新企业已配置的「联系我」方式

```php
$api = $api->update(array: $data)
```

### 删除企业已配置的「联系我」方式

```php
$api = $api->delete(string: '配置ID')
```