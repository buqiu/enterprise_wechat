<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class DelExternalContact extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'user_id'          => $data['UserID']         ?? null,
            'external_user_id' => $data['ExternalUserID'] ?? null,
            'delete_source'    => $data['Source']         ?? null,
            'delete_type'      => $data['ChangeType']     ?? null,
        ];
    }
}
