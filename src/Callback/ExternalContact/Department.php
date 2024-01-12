<?php

declare(strict_types=1);

/**
 * @note   Department${CARET}
 * @author Lu
 */

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class Department
{
    // 事件类型
    public const EVENT_TYPE = 'change_contact';

    // 创建部门
    public const CHANGE_TYPE_CREATE = 'create_party';

    // 更新部门
    public const CHANGE_TYPE_UPDATE = 'update_party';

    // 删除部门
    public const CHANGE_TYPE_delete = 'delete_party';

    public static array $changeTypeMap = [
        self::CHANGE_TYPE_CREATE => 1,
        self::CHANGE_TYPE_UPDATE => 2,
        self::CHANGE_TYPE_delete => 3,
    ];

    // 变更企业客户事件
    public static function change($xmlArray): bool|array
    {
        if (!self::preHandel($xmlArray)) {
            return false;
        }

        return [
            'changeType' => self::$changeTypeMap[$xmlArray['ChangeType']] ?? null,
            'id'         => $xmlArray['Id']                               ?? null,
            'parentId'   => $xmlArray['ParentId']                         ?? null,
            'name'       => $xmlArray['Name']                             ?? null,
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
