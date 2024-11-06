<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\LogHelper;

class UserEvent extends Event
{
    public function getAccountId()
    {
        return $this->data['user_id'];
    }

    public function bind(): mixed
    {
        $user = User::withCorpId()->whereAccountId($this->getAccountId())->withTrashed()->firstOrFail();

        LogHelper::event(static::class, $user->toArray());

        return $user;
    }
}
