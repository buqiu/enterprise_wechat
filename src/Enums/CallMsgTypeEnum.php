<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Enums;

enum CallMsgTypeEnum: string
{
    case MSG_TYPE_EVENT = 'event';

    public static function exist(string $msg_type): bool
    {
        return match ($msg_type) {
            self::MSG_TYPE_EVENT->value => true,
            default                     => false,
        };
    }
}
