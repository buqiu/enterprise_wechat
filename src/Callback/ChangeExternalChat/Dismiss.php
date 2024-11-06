<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalChat;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class Dismiss extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'chat_id' => $data['ChatId'] ?? null,
        ];
    }
}
