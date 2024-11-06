### 消息推送管理
```php
$welcome = EnterpriseWechatFacade::welcome();
```
---

### 发送新客户欢迎语
```php
$welcome->welcome(string: '欢迎语Code', array: $data); # data https://developer.work.weixin.qq.com/document/path/92137
```

### 添加入群欢迎语素材
```php
$welcome->addTemplate(array: $data); # data https://developer.work.weixin.qq.com/document/path/92366
```

### 编辑入群欢迎语素材
```php
$welcome->editTemplate(array: $data); # data https://developer.work.weixin.qq.com/document/path/92366
```

### 获取入群欢迎语素材
```php
$welcome->getTemplate(string: '模板ID');
```

### 删除入群欢迎语素材
```php
$welcome->delTemplate(string: '模板ID');
```
