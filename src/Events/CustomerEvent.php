<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\LogHelper;

class CustomerEvent extends Event
{
    public function getAccountId()
    {
        return $this->data['user_id'];
    }

    public function getExternalUserId()
    {
        return $this->data['external_user_id'];
    }

    public function getUserId()
    {
        $user = User::withCorpId()->whereAccountId($this->getAccountId())->firstOrFail();

        return $user->getKey();
    }

    public function bind(): mixed
    {
        $customer = Customer::withCorpId()
            ->whereUserId($this->getUserId())
            ->whereExternalUserId($this->getExternalUserId())
            ->withTrashed()
            ->firstOrFail();

        LogHelper::event(static::class, $customer->toArray());

        return $customer;
    }
}
