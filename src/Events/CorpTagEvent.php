<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Buqiu\EnterpriseWechat\Utils\LogHelper;

class CorpTagEvent extends Event
{
    public function bind(): mixed
    {
        [$tagData, $tagGroup] = $this->data;

        $tagIds = [];
        if (ArrHelper::notEmpty($tagData, 'id')) {
            $tagIds = CorpTag::withCorpId()->whereTagId($tagData['id'])->withTrashed()->get();
        }

        if (ArrHelper::notEmpty($tagGroup, 'id')) {
            $tagIds = CorpTag::withCorpId()->whereGroupId($tagGroup['id'])->withTrashed()->get();
        }

        LogHelper::event(static::class, is_array($tagIds) ? $tagIds : $tagIds->toArray());

        return $tagIds;
    }
}
