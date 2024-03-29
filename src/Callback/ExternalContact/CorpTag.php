<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class CorpTag
{
    /**
     * 事件的类型.
     */
    public const EVENT_TYPE = 'change_external_tag';

    /**
     * 企业客户标签创建事件.
     */
    public const CHANGE_TYPE_ADD = 'create';

    /**
     * 企业客户标签变更事件.
     */
    public const CHANGE_TYPE_EDIT = 'update';

    /**
     * 企业客户标签删除事件.
     */
    public const CHANGE_TYPE_DEL = 'delete';

    /**
     * 企业客户标签重排事件.
     */
    public const CHANGE_TYPE_SHUFFLE = 'shuffle';

    /**
     * 标签类型: 标签.
     */
    public const TAG_TYPE = 'tag';

    /**
     * 标签类型: 标签组.
     */
    public const TAG_GROUP_TYPE = 'tag_group';

    public static array $changeTypeMap = [
        self::CHANGE_TYPE_ADD     => 1,
        self::CHANGE_TYPE_EDIT    => 2,
        self::CHANGE_TYPE_DEL     => 3,
        self::CHANGE_TYPE_SHUFFLE => 4,
    ];

    public static array $tagTypeMap = [
        self::TAG_TYPE       => 1,
        self::TAG_GROUP_TYPE => 2,
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
            'changeType' => self::$changeTypeMap[$xmlArray['ChangeType']] ?? 0,
            'tagType'    => self::$tagTypeMap[$xmlArray['TagType']]       ?? 0,
            'id'         => $xmlArray['Id'],
            'strategyId' => $xmlArray['StrategyId'] ?? 0,
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
