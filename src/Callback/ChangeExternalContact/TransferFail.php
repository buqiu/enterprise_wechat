<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;
use Buqiu\EnterpriseWechat\Enums\TransferCustomer\TransferStatusEnum;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Buqiu\EnterpriseWechat\Models\User;

class TransferFail extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'account_id'       => (string) ($data['UserID'] ?? null),
            'user_id'          => TransferFail::getUserId((string) ($data['UserID'] ?? null)),
            'external_user_id' => $data['ExternalUserID'] ?? null,
            'union_id'         => TransferFail::getUnionId($data['ExternalUserID'] ?? null),
            'fail_reason'      => $data['FailReason'] ?? null,
            'errcode'          => TransferFail::castFailReason($data['FailReason'] ?? null),
        ];
    }

    public static function castFailReason($failReason)
    {
        $failList = [
            'customer_refused'      => TransferStatusEnum::TRANSFER_STATUS_REFUSE->value,
            'customer_limit_exceed' => TransferStatusEnum::TRANSFER_STATUS_LIMIT_EXCEED->value,
        ];

        return $failList[$failReason] ?? null;
    }

    public static function getUserId(?string $account_id = null)
    {
        $user = User::withCorpId()->whereAccountId($account_id)->firstOrFail();

        return $user->getKey();
    }

    public static function getUnionId(?string $external_user_id = null)
    {
        $customer = Customer::withCorpId()->whereExternalUserId($external_user_id)->first();

        return object_get($customer, 'union_id');
    }
}
