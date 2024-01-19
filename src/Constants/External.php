<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Constants;

class External
{
    /**
     * 企微删客户.
     */
    public const DEL_TYPE_EXTERNAL = 'del_external_contact';

    /**
     * 客户删企微.
     */
    public const DEL_TYPE_FOLLOW = 'del_follow_user';

    /**
     * 删除类型映射.
     */
    public static array $delTypeMap = [
        self::DEL_TYPE_EXTERNAL,
        self::DEL_TYPE_FOLLOW,
    ];
}
