<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Examples;

require dirname(__DIR__).'/../vendor/autoload.php';

use Buqiu\EnterpriseWechat\Api\CorpApi;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\ExternalContact;

$config = require './config.php';
$api    = new CorpApi($config['CORP_ID'], $config['CORP_SECRET']);

try {
    // 获取配置了客户联系功能的成员列表
    $r = $api->getFollowUserList();
    print_r($r->followUserIds);

    // 获取客户列表
    $e         = new ExternalContact();
    $e->userId = 'eva';
    $r         = $api->getExternalContactList($e);
    print_r($r->externalUserList);

    // 获取客户详情
    $e                 = new ExternalContact();
    $e->externalUserId = 'wm2AytCgAA2L8BK2ghke7xJMe9RnL3Ug';
    $r                 = $api->getExternalContact($e);
    print_r($r);

    // 批量获取客户信息
    $e            = new ExternalContact();
    $e->userIds[] = 'eva';
    $r            = $api->batchGetExternalContacts($e);
    print_r($r);
} catch (\Exception $e) {
    echo "{$e->getMessage()}\n";
}
