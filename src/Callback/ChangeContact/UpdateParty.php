<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class UpdateParty extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'id'       => $data['Id']       ?? null,
            'parentid' => $data['ParentId'] ?? null,
            'name'     => $data['Name']     ?? null,
        ];
    }
}
