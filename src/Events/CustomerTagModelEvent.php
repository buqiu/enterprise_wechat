<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

// 客户标签事件
class CustomerTagModelEvent extends ModelEvent
{
    public function getId(): array
    {
        return [$this->id];
    }
}
