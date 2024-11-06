<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events\ChangeExternalTag;

use Buqiu\EnterpriseWechat\Events\CorpTagEvent;
use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Buqiu\EnterpriseWechat\Utils\LogHelper;

/**
 * 企业客户标签创建事件
 */
class CreateEvent extends CorpTagEvent
{
    public function bind(): mixed
    {
        [$tagData, $tagGroup] = $this->data;

        $tagIds = [];
        if (ArrHelper::notEmpty($tagData, 'id')) {
            $tagIds = CorpTag::withCorpId()->whereTagId($tagData['id'])->withTrashed()->get();
        }

        LogHelper::event(static::class, is_array($tagIds) ? $tagIds : $tagIds->toArray());

        return $tagIds;
    }
}
