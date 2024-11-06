### 通讯录回调通知 `API` 调用
```php
$api = EnterpriseWechatFacade::callback()->api();
```

---

### 验证回调URL

```php
$api = $api->verifyUrl(string: '签名串', string: '时间戳', string: '随机串', string: '输出随机串')
```

### 解密原文

```php
$api = $api->decryptMsg(string: '签名串', string '随机串', string: '密文', string: '解密后的原文', string: '时间戳')
```

