<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeContact;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;
use Buqiu\EnterpriseWechat\Utils\Utils;

class UpdateTag extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'tag_id'          => $data['TagId'] ?? null,
            'add_user_list'  => UpdateTag::parseComma($data['AddUserItems'] ?? null),
            'del_user_list'  => UpdateTag::parseComma($data['DelUserItems'] ?? null),
            'add_party_list' => UpdateTag::parseComma($data['AddPartyItems'] ?? null),
            'del_party_list' => UpdateTag::parseComma($data['DelPartyItems'] ?? null),
        ];
    }

    public static function parseComma(mixed $data): array
    {
        if (is_array($data)) {
            return $data;
        }

        if (Utils::empty($data)) {
            return [];
        }

        return explode(',', $data);
    }
}
