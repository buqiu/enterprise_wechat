<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Constants;

class Transfer
{
    /**
     * 接替完毕.
     */
    public const STATUS_COMPLETE = 1;

    /**
     * 等待接替.
     */
    public const STATUS_WAIT = 2;

    /**
     * 客户拒绝.
     */
    public const STATUS_CUSTOMER_REFUSE = 3;

    /**
     * 接替成员客户达到上限.
     */
    public const STATUS_CUSTOMER_EXCEED_LIMIT = 4;

    /**
     * 接替类型-在职.
     */
    public const TRANSFER_TYPE_NORMAL = 'normal';

    /**
     * 接替类型-离职.
     */
    public const TRANSFER_TYPE_RESIGNED = 'resigned';

    /**
     * 回调接替失败状态-客户拒绝.
     */
    public const CALLBACK_STATUS_CUSTOMER_REFUSED = 'customer_refused';

    /**
     * 回调接替失败状态-接替成员的客户数达到上限.
     */
    public const CALLBACK_STATUS_CUSTOMER_LIMIT_EXCEED = 'customer_limit_exceed';

    /**
     * 状态映射.
     */
    public static array $statusMap = [
        self::STATUS_COMPLETE              => '接替完成',
        self::STATUS_WAIT                  => '等待接替',
        self::STATUS_CUSTOMER_REFUSE       => '客户拒绝',
        self::STATUS_CUSTOMER_EXCEED_LIMIT => '接替成员客户达到上限',
    ];

    /**
     * 回调状态映射.
     */
    public static array $callbackStatusMap = [
        self::CALLBACK_STATUS_CUSTOMER_REFUSED      => '客户拒绝',
        self::CALLBACK_STATUS_CUSTOMER_LIMIT_EXCEED => '接替成员客户达到上限',
    ];

    /**
     * 类型映射.
     */
    public static array $typeMap = [
        self::TRANSFER_TYPE_NORMAL,
        self::TRANSFER_TYPE_RESIGNED,
    ];
}
