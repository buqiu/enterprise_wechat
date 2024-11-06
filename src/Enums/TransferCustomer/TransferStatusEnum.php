<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Enums\TransferCustomer;

use Exception;

/**
 * 接替状态
 */
enum TransferStatusEnum: int
{
    case TRANSFER_STATUS_START = 0;

    case TRANSFER_STATUS_SUCCESS = 1;

    case TRANSFER_STATUS_READY = 2;

    case TRANSFER_STATUS_REFUSE = 3;

    case TRANSFER_STATUS_LIMIT_EXCEED = 4;

    /**
     * @throws Exception
     */
    public function label(): string
    {
        return match ($this) {
            self::TRANSFER_STATUS_START        => '发起接替',
            self::TRANSFER_STATUS_SUCCESS      => '接替完毕',
            self::TRANSFER_STATUS_READY        => '等待接替',
            self::TRANSFER_STATUS_REFUSE       => '客户拒绝',
            self::TRANSFER_STATUS_LIMIT_EXCEED => '接替成员客户达到上限',
            default                            => '转接失败',
        };
    }
}
