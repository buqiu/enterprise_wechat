<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Enums\User;

use Exception;

/**
 * 激活状态
 */
enum UserStatusEnum: int
{
    case STATUS_ACTIVE = 1;

    case STATUS_DISABLE = 2;

    case STATUS_NOT_ACTIVE = 4;

    case STATUS_EXIT = 5;

    case STATUS_RESIGN = 6;

    /**
     * @throws Exception
     */
    public function label(): string
    {
        return match ($this) {
            self::STATUS_ACTIVE     => '已激活',
            self::STATUS_DISABLE    => '已禁用',
            self::STATUS_NOT_ACTIVE => '未激活',
            self::STATUS_EXIT       => '退出企业',
            self::STATUS_RESIGN     => '离职',
        };
    }
}
