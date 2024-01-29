<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Tag;

use Buqiu\EnterpriseWechat\Utils\Utils;

class CorpTag
{
    /**
     * 标签组 ID.
     */
    public ?string $groupId = null;

    /**
     * 标签组 ID 集合.
     */
    public ?array $groupIdList = null;

    /**
     * 标签组名称.
     */
    public ?string $groupName = null;

    /**
     * 标签组顺序.
     */
    public ?int $groupOrder = null;

    /**
     * 标签组信息.
     */
    public ?array $groups = null;

    /**
     * 标签 ID.
     */
    public ?string $tagId = null;

    /**
     * 标签 ID 集合.
     */
    public ?array $tagIdList = null;

    /**
     * 标签名称.
     */
    public ?string $tagName = null;

    /**
     * 标签顺序.
     */
    public ?int $tagOrder = null;

    /**
     * 标签信息.
     */
    public ?array $tags = null;

    /**
     * 添加外部联系人的 user id.
     */
    public ?string $userId = null;

    /**
     * 外部联系人的 user id.
     */
    public ?string $externalUserId = null;

    /**
     * 要标记的标签列表.
     */
    public ?array $addTags = null;

    /**
     * 要移除的标签列表.
     */
    public ?array $removeTags = null;

    /**
     * @note 处理【获取企业客户标签】请求参数
     * @author eva
     *
     * @param $corpTag
     * @return array
     */
    public static function handleListArgs($corpTag): array
    {
        $args = [];

        Utils::setIfNotNull($corpTag->groupId, 'group_id', $args);
        Utils::setIfNotNull($corpTag->tagId, 'tag_id', $args);

        return $args;
    }

    /**
     * @note 处理【获取企业客户标签】响应数据
     * @author eva
     *
     * @param $rsp
     * @return CorpTag
     */
    public static function handleListRsp($rsp): CorpTag
    {
        $c = new CorpTag();

        if (!Utils::notEmptyArr($rsp['tag_group'])) {
            return $c;
        }

        foreach ($rsp['tag_group'] as $tagGroup) {
            // 标签组已删除
            //            if (isset($tagGroup['deleted']) && $tagGroup['deleted']) {
            //                continue;
            //            }
            $c->groups[$tagGroup['group_id']] = ['name' => $tagGroup['group_name'], 'deleted' => $tagGroup['deleted'], 'create_time' => $tagGroup['create_time'], 'order' => $tagGroup['order']];

            $c->groups[$tagGroup['group_id']] = ['name' => $tagGroup['group_name']];

            // 子标签为空
            if (empty($tagGroup['tag'])) {
                continue;
            }

            foreach ($tagGroup['tag'] as $item) {
                // 标签已删除
                //                if (isset($item['deleted']) && $item['deleted']) {
                //                    continue;
                //                }

                $c->groups[$tagGroup['group_id']]['tags'][$item['id']] = [
                    'name' => $item['name'],
                ];

                $c->tags[$item['id']] = [
                    'name'        => $item['name'],
                    'deleted'     => $item['deleted'],
                    'create_time' => $item['create_time'],
                    'order'       => $item['order'],
                    'group'       => ['id' => $tagGroup['group_id'], 'name' => $tagGroup['group_name']],
                ];
            }
        }

        return $c;
    }

    /**
     * @note 校验【添加企业客户标签】请求参数
     * @author eva
     *
     * @param  CorpTag    $corpTag
     * @throws \Exception
     */
    public static function checkAddArgs(CorpTag $corpTag)
    {
        if (!Utils::notEmptyStr($corpTag->groupId) && !Utils::notEmptyStr($corpTag->groupName)) {
            throw new \Exception('group id, group name both cannot be empty');
        }

        Utils::checkNotEmptyArray($corpTag->tags, 'tags');
    }

    /**
     * @note 处理【添加企业客户标签】请求参数
     * @author eva
     *
     * @param  CorpTag $corpTag
     * @return array
     */
    public static function handleAddArgs(CorpTag $corpTag): array
    {
        $args = [];

        Utils::setIfNotNull($corpTag->groupId, 'group_id', $args);
        Utils::setIfNotNull($corpTag->groupName, 'group_name', $args);
        Utils::setIfNotNull($corpTag->groupOrder, 'order', $args);
        Utils::setIfNotNull($corpTag->tags, 'tag', $args);

        return $args;
    }

    /**
     * @note 处理【添加企业客户标签】响应参数
     * @author eva
     *
     * @param  array   $rsp
     * @return CorpTag
     */
    public static function handleAddRsp(array $rsp): CorpTag
    {
        $c = new CorpTag();

        if (!Utils::notEmptyArr($rsp['tag_group'] ?? [])) {
            return $c;
        }
        $c->groups = $rsp['tag_group'];

        if (!Utils::notEmptyArr($rsp['tag_group']['tag'] ?? [])) {
            return $c;
        }
        $c->tags = $rsp['tag_group']['tag'];

        return $c;
    }

    /**
     * @note 校验【编辑企业客户标签】请求参数
     * @author eva
     *
     * @param  CorpTag    $corpTag
     * @throws \Exception
     */
    public static function checkEditArgs(CorpTag $corpTag)
    {
        if ((Utils::notEmptyStr($corpTag->groupId) && Utils::notEmptyStr($corpTag->tagId))
            || (Utils::notEmptyStr($corpTag->groupName) && Utils::notEmptyStr($corpTag->tagName))
            || (Utils::notEmptyStr($corpTag->groupOrder) && Utils::notEmptyStr($corpTag->tagOrder))
        ) {
            throw new \Exception('both are not allowed to have values');
        }

        if (!Utils::notEmptyStr($corpTag->groupId) && !Utils::notEmptyStr($corpTag->tagId)) {
            throw new \Exception('both cannot be empty');
        }
    }

    /**
     * @note 处理【添加企业客户标签】请求参数
     * @author eva
     *
     * @param  CorpTag $corpTag
     * @return array
     */
    public static function handleEditArgs(CorpTag $corpTag): array
    {
        $args = [];

        Utils::setIfNotNull($corpTag->groupId, 'id', $args);
        Utils::setIfNotNull($corpTag->tagId, 'id', $args);
        Utils::setIfNotNull($corpTag->groupName, 'name', $args);
        Utils::setIfNotNull($corpTag->tagName, 'name', $args);
        Utils::setIfNotNull($corpTag->groupOrder, 'order', $args);
        Utils::setIfNotNull($corpTag->tagOrder, 'order', $args);

        return $args;
    }

    /**
     * @note 校验【删除企业客户标签】请求参数
     * @author eva
     *
     * @param  CorpTag    $corpTag
     * @throws \Exception
     */
    public static function checkDelArgs(CorpTag $corpTag)
    {
        if (!Utils::notEmptyArr($corpTag->groupIdList) && !Utils::notEmptyArr($corpTag->tagIdList)) {
            throw new \Exception('both cannot be empty');
        }
    }

    /**
     * @note 处理【删除企业客户标签】请求参数
     * @author eva
     *
     * @param $corpTag
     * @return array
     */
    public static function handleDelArgs($corpTag): array
    {
        $args = [];
        Utils::setIfNotNull($corpTag->tagIdList, 'tag_id', $args);
        Utils::setIfNotNull($corpTag->groupIdList, 'group_id', $args);

        return $args;
    }

    /**
     * @note 校验【编辑客户企业标签】请求参数
     * @author eva
     *
     * @param  CorpTag    $corpTag
     * @throws \Exception
     */
    public static function checkMarkArgs(CorpTag $corpTag)
    {
        Utils::checkNotEmptyStr($corpTag->userId, 'userid');
        Utils::checkNotEmptyStr($corpTag->externalUserId, 'external_userid');
        Utils::checkAllEmptyArray(['add_tag' => $corpTag->addTags, 'remove_tag' => $corpTag->removeTags]);
    }

    /**
     * @note 处理【编辑客户企业标签】请求参数
     * @author eva
     *
     * @param  CorpTag $corpTag
     * @return array
     */
    public static function handleMarkArgs(CorpTag $corpTag): array
    {
        $args = [];
        Utils::setIfNotNull($corpTag->userId, 'userid', $args);
        Utils::setIfNotNull($corpTag->externalUserId, 'external_userid', $args);
        Utils::setIfNotNull($corpTag->addTags, 'add_tag', $args);
        Utils::setIfNotNull($corpTag->removeTags, 'remove_tag', $args);

        return $args;
    }
}
