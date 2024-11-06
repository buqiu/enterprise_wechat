### 素材 `API` 调用
```php
$api = EnterpriseWechatFacade::media()->api();
```
---
### 上传临时素材
```php
$api->upload(array: $data); # data: https://developer.work.weixin.qq.com/document/path/90253
```

### 上传图片
```php
$api->uploadImg(array $data); # data: https://developer.work.weixin.qq.com/document/path/90256
```

### 异步上传临时素材
```php
$api->uploadByUrl(array: $data); # data https://developer.work.weixin.qq.com/document/path/90255
```

### 查询异步任务结果
```php
$api->getUploadByUrlResult(string '任务ID');
```
