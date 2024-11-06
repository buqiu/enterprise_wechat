
### 身份认证管理
```php
$auth = EnterpriseWechatFacade::auth();
```
---

### 返回静默授权跳转链接
```php
$callback->redirectBase(string: '回调地址');
```

### 返回手动授权跳转链接
```php
$callback->redirectPrivateInfo(string: '回调地址');
```

### 返回服务商登录跳转链接
```php
$callback->redirectServiceApp(string: '回调地址');
```

### 返回企业自建/代开发应用登录跳转链接
```php
$callback->redirectCorpApp(string: '回调地址');
```

### 获取用户信息
```php
$callback->getUserInfo(string: 'Code码');
```

### 获取用户敏感信息
```php
$callback->getUserDetail(string: '成员票据')
```

### 获取用户二次验证信息
```php
$callback->getTfaInfo(string: 'Code码')
```

### 登录二次验证
```php
$callback->authSuccess(string: '成员ID')
```

### 使用二次验证
```php
$callback->tfaSuccess(string: '成员ID', string: '二次验证授权码')
```
