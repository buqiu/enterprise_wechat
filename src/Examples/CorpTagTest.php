<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Examples;

require dirname(__DIR__).'/../vendor/autoload.php';

use Buqiu\EnterpriseWechat\Api\CorpApi;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Tag\CorpTag;

$config = require './config.php';
$api    = new CorpApi($config['CORP_ID'], $config['CORP_SECRET']);

try {
    // 添加企业客户标签
    $c          = new CorpTag();
    $c->groupId = $config['JOIN_TRAINING_GROUP_ID'];
    $c->tags    = ['name' => '测试001号'];
    $r          = $api->addCorpTag($c);
    print_r($r->groups);
    print_r($r->tags);

    $tagId = $r->tags[0]['id'];
    // 编辑企业客户标签
    $c          = new CorpTag();
    $c->tagId   = $tagId;
    $c->tagName = '测试007';
    $api->editCorpTag($c);

    // 编辑客户企业标签
    $c                 = new CorpTag();
    $c->userId         = 'eva';
    $c->externalUserId = 'wm2AytCgAA2L8BK2ghke7xJMe9RnL3Ug';
    $c->addTags        = [$tagId];
    $api->markCorpTag($c);

    // 获取企业标签库
    $c          = new CorpTag();
    $c->groupId = $config['JOIN_TRAINING_GROUP_ID'];
    $r          = $api->getCorpTagList($c);
    print_r($r->groups);
    print_r($r->tags);

    // 删除客户企业标签
    $c            = new CorpTag();
    $c->tagIdList = [$tagId];
    $api->delCorpTag($c);
} catch (\Exception $e) {
    echo $e->getMessage()."\n";

    if (!empty($tagId)) {
        // 删除客户企业标签
        $c            = new CorpTag();
        $c->tagIdList = [];
        $api->delCorpTag($c);
    }
}
