<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Examples;

require dirname(__DIR__).'/../vendor/autoload.php';

use Buqiu\EnterpriseWechat\Api\CorpApi;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\MessagePush\AddMsgTemplate;

$config = require './config.php';
$api    = new CorpApi($config['CORP_ID'], $config['CORP_SECRET']);

try {
    // 创建企业群发
    $m                 = new AddMsgTemplate();
    $m->chatType       = 'single';
    $m->externalUserId = ['wm2AytCgAA2L8BK2ghke7xJMe9RnL3Ug'];
    $m->sender         = 'eva';
    $m->text           = ['content' => 'test'];
    $r                 = $api->addMsgTemplate($m);
    print_r($r->failList);
    print_r($r->msgId);
} catch (\Exception $e) {
    echo "{$e->getMessage()}\n";
}
