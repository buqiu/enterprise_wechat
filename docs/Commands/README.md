
<h1>企业微信账号管理</h1>

为了方便维护企微账号的管理, 本扩展包提供了 `Artisan` 命令行方式管理企微账号。

---

### 注册企微账号
此步操作需要提供[企微信息](https://developer.work.weixin.qq.com/document/path/90665#secret)
```shell
 php artisan enterprise-wechat:register
```

### 查看账号
查看已注册的账号列表
```shell
 php artisan enterprise-wechat:list
```

### 更新账号
更新已注册的账号信息
```shell
 php artisan enterprise-wechat:update
```

### 删除账号
删除已注册的账号信息
```shell
 php artisan enterprise-wechat:delete
```

### 重置缓存
删除已缓存的账号信息
```shell
 php artisan enterprise-wechat:cache-clear
```

### 生成同步客户命令
```shell
php artisan enterprise-wechat:customer:generate
```

### 同步客户
```shell
php artisan enterprise-wechat:customer:sync "账号Code" "起始成员ID" "末尾成员ID"
```

### 同步客户标签
```shell
php artisan enterprise-wechat:customer-tag:sync "账号Code"
```
### 同步部门
```shell
php artisan enterprise-wechat:department:sync "账号Code"
```
### 同步成员
```shell
php artisan enterprise-wechat:user:sync "账号Code"
```
### 同步离职成员
```shell
php artisan enterprise-wechat:user-resign:sync "账号Code"
```