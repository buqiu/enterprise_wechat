<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Constants;

class External
{
    /**
     * 删除类型-删除企业客户.
     */
    public const DEL_TYPE_EXTERNAL = 'del_external_contact';

    /**
     * 删除类型-删除跟进人员.
     */
    public const DEL_TYPE_FOLLOW = 'del_follow_user';

    /**
     * 删除来源-在职继承自动被转接成员删除.
     */
    public const DEL_SOURCE_BY_TRANSFER = 'DELETE_BY_TRANSFER';

    /**
     * 删除类型映射.
     */
    public static array $delTypeMap = [
        self::DEL_TYPE_EXTERNAL,
        self::DEL_TYPE_FOLLOW,
    ];

    /**
     * 删除来源映射.
     */
    public static array $delSourceMap = [
        self::DEL_SOURCE_BY_TRANSFER,
    ];
}
