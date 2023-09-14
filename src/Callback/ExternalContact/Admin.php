<?php

declare(strict_types=1);

/**
 * @note   Admin${CARET}
 * @author Lu
 */

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class Admin
{
    // 事件类型

    public const EVENT_TYPE = 'change_contact';

    // 新增成员
    public const CHANGE_TYPE_CREATE = 'create_user';

    // 更新成员
    public const CHANGE_TYPE_UPDATE = 'update_user';

    // 删除成员
    public const CHANGE_TYPE_DELETE = 'delete_user';

    public static array $changeTypeMap = [
        self::CHANGE_TYPE_CREATE => 1,
        self::CHANGE_TYPE_UPDATE => 2,
        self::CHANGE_TYPE_DELETE => 3,
    ];

    // 变更企业用户
    public static function change($xmlArray)
    {
        if (!self::preHandel($xmlArray)) {
            return false;
        }

        return [
            'changeType'  => self::$changeTypeMap[$xmlArray['ChangeType']] ?? 0,
            'user_id'     => $xmlArray['UserID']                           ?? null,
            'department'  => $xmlArray['Department']                       ?? null,
            'new_user_id' => $xmlArray['NewUserId']                        ?? null,
        ];
    }

    // 预处理数据
    private static function preHandel($xmlArray): bool
    {
        if (empty($xmlArray['Event']) || empty($xmlArray['ChangeType'])) {
            return false;
        }

        if (self::EVENT_TYPE != $xmlArray['Event']) {
            return false;
        }

        if (!in_array($xmlArray['ChangeType'], array_keys(self::$changeTypeMap))) {
            return false;
        }

        return true;
    }
}
