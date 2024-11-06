### 素材管理
```php
$media = EnterpriseWechatFacade::message();
```
---
### 上传临时素材
```php
$message->upload(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90253
```

### 上传图片
```php
$message->uploadImg(array $data); # data: https://developer.work.weixin.qq.com/document/path/90256
```

### 异步上传临时素材
```php
$message->uploadByUrl(array: $data); # data https://developer.work.weixin.qq.com/document/path/90255
```

### 查询异步任务结果
```php
$message->getUploadByUrlResult(string '任务ID');
```
