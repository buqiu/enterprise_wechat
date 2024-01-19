<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact;

use Buqiu\EnterpriseWechat\Utils\Utils;

class ExternalContact
{
    /**
     * 外部联系人的 userid.
     */
    public ?string $externalUserId = null;

    /**
     * 外部联系人在微信开放平台的唯一身份标识.
     */
    public ?string $unionId = null;

    /**
     * 分页游标.
     */
    public ?string $cursor = null;

    /**
     * 企业成员的 userid.
     */
    public ?string $userId = null;

    /**
     * 企业成员的 userid 列表.
     */
    public ?array $userIds = null;

    /**
     * 返回的最大记录数.
     */
    public int $limit = 100;

    /**
     * 外部联系人的 userid 集合.
     */
    public ?array $externalUserList = null;

    /**
     * 添加了外部联系人的企业成员信息.
     */
    public array $followUserInfo = [];

    /**
     * 添加了外部联系人的企业 ID.
     */
    public array $followUserIds = [];

    /**
     * 用户所拥有的标签.
     */
    public array $tags = [];

    /**
     * 批次查询条数.
     */
    public static int $batchProcessUserLimit = 100;

    /**
     * 用户头像.
     */
    public ?string $avatar = null;

    /**
     * 用户类型.
     */
    public ?string $type = null;

    /**
     * 用户性别.
     */
    public ?int $gender = null;

    /**
     * 昵称.
     */
    public ?string $name = null;

    /**
     * @note 处理【获取配置了客户联系功能的成员列表】
     * @author eva
     *
     * @param  array           $rsp
     * @return ExternalContact
     */
    public static function handleGetFollowUserRsp(array $rsp): ExternalContact
    {
        $e = new ExternalContact();

        if (Utils::notEmptyArr($rsp['follow_user'] ?? [])) {
            $e->followUserIds = $rsp['follow_user'];
        }

        return $e;
    }

    /**
     * @note 校验【批量获取客户详情】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @throws \Exception
     */
    public static function checkBatchGetArgs(ExternalContact $externalContact)
    {
        Utils::checkNotEmptyArray($externalContact->userIds, 'userid_list');
    }

    /**
     * @note 处理【批量获取客户详情】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @return array
     */
    public static function handleBatchGetArgs(ExternalContact $externalContact): array
    {
        $args = [];

        Utils::setIfNotNull($externalContact->userIds, 'userid_list', $args);
        Utils::setIfNotNull($externalContact->limit, 'limit', $args);
        Utils::setIfNotNull($externalContact->cursor, 'cursor', $args);

        return $args;
    }

    /**
     * @note 处理【批量获取客户详情】响应数据
     * @author eva
     *
     * @param  array           $rsp
     * @return ExternalContact
     */
    public static function handleBatchGetRsp(array $rsp): ExternalContact
    {
        $e = new ExternalContact();

        if (Utils::notEmptyStr($rsp['next_cursor'])) {
            $e->cursor = $rsp['next_cursor'];
        }

        if (Utils::notEmptyArr($rsp['external_contact_list'])) {
            $e->externalUserList = $rsp['external_contact_list'];
        }

        return $e;
    }

    /**
     * @note 校验【获取客户列表】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @throws \Exception
     */
    public static function checkGetListArgs(ExternalContact $externalContact)
    {
        Utils::checkNotEmptyStr($externalContact->userId, 'userid');
    }

    /**
     * @note 处理【获取客户列表】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @return array
     */
    public static function handleGetListArgs(ExternalContact $externalContact): array
    {
        $args = [];
        Utils::setIfNotNull($externalContact->userId, 'userid', $args);

        return $args;
    }

    /**
     * @note 处理【获取客户列表】响应数据
     * @author eva
     *
     * @param  array           $rsp
     * @return ExternalContact
     */
    public static function handleGetListRsp(array $rsp): ExternalContact
    {
        $e = new ExternalContact();

        if (Utils::notEmptyArr($rsp['external_userid'] ?? [])) {
            $e->externalUserList = $rsp['external_userid'];
        }

        return $e;
    }

    /**
     * @note 校验【获取客户详情】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @throws \Exception
     */
    public static function checkGetArgs(ExternalContact $externalContact)
    {
        Utils::checkNotEmptyStr($externalContact->externalUserId, 'external_userid');
    }

    /**
     * @note 处理【获取客户详情】请求参数
     * @author eva
     *
     * @param  ExternalContact $externalContact
     * @return array
     */
    public static function handleGetArgs(ExternalContact $externalContact): array
    {
        $args = [];
        Utils::setIfNotNull($externalContact->externalUserId, 'external_userid', $args);
        Utils::setIfNotNull($externalContact->cursor, 'cursor', $args);

        return $args;
    }

    /**
     * @note 处理【获取客户详情】响应参数
     * @author eva
     *
     * @param  array           $rsp
     * @return ExternalContact
     */
    public static function handleGetRsp(array $rsp): ExternalContact
    {
        $e = new ExternalContact();
        if (Utils::notEmptyStr($rsp['next_cursor'] ?? '')) {
            $e->cursor = $rsp['next_cursor'];
        }

        if (array_key_exists('external_contact', $rsp)) {
            $e->externalUserId = $rsp['external_contact']['external_userid'] ?? null;
            $e->name           = $rsp['external_contact']['name']            ?? null;
            $e->unionId        = $rsp['external_contact']['unionid']         ?? null;
            $e->avatar         = $rsp['external_contact']['avatar']          ?? null;
            $e->type           = $rsp['external_contact']['type']            ?? null;
            $e->gender         = $rsp['external_contact']['gender']          ?? null;
        }

        if (Utils::notEmptyArr($rsp['follow_user'] ?? [])) {
            foreach ($rsp['follow_user'] ?? [] as $item) {
                $e->followUserIds = array_merge($e->followUserIds, [$item['userid']]);

                $tags = ($item['tags'] && is_array($item['tags'])) ? array_column($item['tags'], 'tag_id') : [];

                if (isset($e->followUserInfo[$item['userid']])) {
                    $e->followUserInfo[$item['userid']] = array_merge(
                        $e->followUserInfo[$item['userid']]['tags'],
                        $tags
                    );
                } else {
                    $e->followUserInfo[$item['userid']]['tags']       = $tags;
                    $e->followUserInfo[$item['userid']]['remark']     = $item['remark'];
                    $e->followUserInfo[$item['userid']]['createtime'] = $item['createtime'];
                    $e->followUserInfo[$item['userid']]['add_way']    = $item['add_way'];
                }

                if (!empty($item['tags']) && is_array($item['tags'])) {
                    $e->tags = array_merge($e->tags, array_column($item['tags'], 'tag_id'));
                }
            }
        }

        return $e;
    }
}
