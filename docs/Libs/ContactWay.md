### 客户联系「联系我」
```php
$contactWay = EnterpriseWechatFacade::contactWay();
```
---

### 配置客户联系「联系我」方式

```php
$contactWay->create(data: $data)
```

### 更新企业已配置的「联系我」方式

```php
$contactWay->update(string: '配置ID', array: $data)
```

### 删除企业已配置的「联系我」方式

```php
$contactWay->delete(string: '配置ID')
```
