# Enterprise Wechat
official lib of enterprise weChat api https://work.weixin.qq.com/api/doc
# How to Run
1. require composer lib
```shell
composer require buqiu/enterprise_wechat
```
2. publish the package configuration file config/qy.php
```shell
php artisan vendor:publish
```
3. edit config
```php
return [
    "CORP_ID"                => "",
    "CORP_SECRET"            => "",
    "ENCODING_AES_KEY"       => "",
    "TOKEN"                  => "",
    "AGENT_ID"               => "",
    "JOIN_TRAINING_GROUP_ID" => ""
];
```
# Example
reference `src/Examples`
 
