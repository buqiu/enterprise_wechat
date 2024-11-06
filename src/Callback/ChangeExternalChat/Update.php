<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalChat;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class Update extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'chat_id'                => $data['ChatId']       ?? null,
            'update_detail'          => $data['UpdateDetail'] ?? null,
            'is_change_member'       => Update::is_change_member($data['UpdateDetail'] ?? null),
            'member_change_list'     => $data['MemChangeList'] ?? [],
            'last_member_version'    => $data['LastMemVer']    ?? null,
            'current_member_version' => $data['CurMemVer']     ?? null,
        ];
    }

    public static function is_change_member(string $update_detail): bool
    {
        return in_array($update_detail, ['add_member', 'del_member']);
    }
}
