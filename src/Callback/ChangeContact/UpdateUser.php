<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class UpdateUser extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'user_id'     => $data['UserID']    ?? null,
            'new_user_id' => $data['NewUserID'] ?? null,
        ];
    }
}
