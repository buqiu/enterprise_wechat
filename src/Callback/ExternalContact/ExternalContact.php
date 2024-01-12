<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class ExternalContact
{
    /**
     * 事件类型.
     */
    public const EVENT_TYPE = 'change_external_contact';

    /**
     * 添加企业客户事件.
     */
    public const CHANGE_TYPE_ADD = 'add_external_contact';

    /**
     * 编辑企业客户事件.
     */
    public const CHANGE_TYPE_EDIT = 'edit_external_contact';

    /**
     * 删除企业客户事件.
     */
    public const CHANGE_TYPE_DEL = 'del_external_contact';

    /**
     * 外部联系人免验证添加成员事件.
     */
    public const CHANGE_TYPE_ADD_HALF = 'add_half_external_contact';

    /**
     * 删除跟进成员事件.
     */
    public const CHANGE_TYPE_DEL_FOLLOW_USER = 'del_follow_user';

    /**
     * 客户接替失败事件.
     */
    public const CHANGE_TYPE_TRANSFER_FAIL = 'transfer_fail';

    /**
     * 企业客户类型映射.
     */
    public static array $changeTypeMap = [
        self::CHANGE_TYPE_ADD             => 1,
        self::CHANGE_TYPE_EDIT            => 2,
        self::CHANGE_TYPE_DEL             => 3,
        self::CHANGE_TYPE_ADD_HALF        => 4,
        self::CHANGE_TYPE_DEL_FOLLOW_USER => 5,
        self::CHANGE_TYPE_TRANSFER_FAIL   => 6,
    ];

    /**
     * @note 变更企业客户事件
     * @author eva
     *
     * @param $xmlArray
     * @return array|bool
     */
    public static function change($xmlArray): bool|array
    {
        if (!self::preHandel($xmlArray)) {
            return false;
        }

        return [
            'changeType'     => self::$changeTypeMap[$xmlArray['ChangeType']] ?? 0,
            'userId'         => $xmlArray['UserID'],
            'externalUserId' => $xmlArray['ExternalUserID'],
            'state'          => $xmlArray['State']       ?? '',
            'welcomeCode'    => $xmlArray['WelcomeCode'] ?? '',
            'source'         => $xmlArray['Source']      ?? '',
            'failReason'     => $xmlArray['FailReason']  ?? '',
        ];
    }

    /**
     * @note 预处理数据
     * @author eva
     *
     * @param $xmlArray
     * @return bool
     */
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
