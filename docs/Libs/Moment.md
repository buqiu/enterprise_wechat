### 朋友圈管理
```php
$moment = EnterpriseWechatFacade::moment();
```
---

### 创建发表任务
```php
$moment->send(array: $data); # data https://developer.work.weixin.qq.com/document/path/95094
```

### 获取任务创建结果
```php
$welcome->getResult(string: '任务ID');
```

### 取消发表任务
```php
$welcome->cancelSend(string: '朋友圈ID');
```
