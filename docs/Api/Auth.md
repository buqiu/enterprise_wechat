### 身份验证 `API` 调用
```php
$api = EnterpriseWechatFacade::auth()->api();
```

---

### 获取授权链接

```php
$api = $api->authorize(string: '回调地址', string: '应用授权作用域', string: 'state 参数')
```

### 获取Web登录链接

```php
$api = $api->sso(string: '回调地址', string: '登录类型', string: 'state 参数', string: '语言类型')
```

### 获取用户信息

```php
$api = $api->getUserInfo(string: 'Code码')
```

### 获取用户敏感信息

```php
$api = $api->getUserDetail(string: '成员票据')
```

### 获取用户二次验证信息

```php
$api = $api->getTfaInfo(string: 'Code码')
```

### 登录二次验证

```php
$api = $api->authSuccess(string: '成员ID')
```

### 使用二次验证

```php
$api = $api->tfaSuccess(string: '成员ID', string: '二次验证授权')
```
