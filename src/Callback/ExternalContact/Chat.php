<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class Chat
{
    /**
     * 事件的类型.
     */
    public const EVENT_TYPE = 'change_external_chat';

    /**
     * 客户群创建事件.
     */
    public const CHANGE_TYPE_ADD = 'create';

    /**
     * 客户群变更事件.
     */
    public const CHANGE_TYPE_EDIT = 'update';

    /**
     * 客户群解散事件.
     */
    public const CHANGE_TYPE_DISMISS = 'dismiss';

    public static array $changeTypeMap = [
        self::CHANGE_TYPE_ADD     => 1,
        self::CHANGE_TYPE_EDIT    => 2,
        self::CHANGE_TYPE_DISMISS => 3,
    ];

    /**
     * @note 客户群事件
     * @author eva
     *
     * @param $xmlArray
     * @return array|false
     */
    public static function change($xmlArray): bool|array
    {
        if (!self::preHandel($xmlArray)) {
            return false;
        }

        return [
            'changeType' => self::$changeTypeMap[$xmlArray['ChangeType']] ?? 0,
            'createTime' => $xmlArray['CreateTime'],
            'chatId'     => $xmlArray['ChatId'],
        ];
    }

    // 预处理数据
    private static function preHandel($xmlArray): bool
    {
        if (empty($xmlArray['Event']) || empty($xmlArray['TagType']) || empty($xmlArray['ChangeType'])) {
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
