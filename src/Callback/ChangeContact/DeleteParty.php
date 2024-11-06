<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class DeleteParty extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'id'       => $data['Id']       ?? null,
        ];
    }
}
