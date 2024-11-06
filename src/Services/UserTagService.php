<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Models\User;

class UserTagService
{
    /**
     * 同步标签成员
     */
    public static function syncList(int $tag_id, array $user_list = []): void
    {
        $users = User::withCorpId()->whereIn('account_id', $user_list)->get();
        foreach ($users as $user) {
            SyncService::addUserTagId($user, $tag_id);
        }
    }

    /**
     * 同步添加的标签成员
     */
    public static function addList(int $tag_id, array $user_list = [], array $party_list = []): void
    {
        UserTagService::addUserList($tag_id, $user_list);

        UserTagService::addPartyList($tag_id, $party_list);
    }

    /**
     * 同步删除的标签成员
     */
    public static function delList(int $tag_id, array $user_list = [], array $party_list = []): void
    {
        UserTagService::delUserList($tag_id, $user_list);

        UserTagService::delByPartList($tag_id, $party_list);
    }

    /**
     * 基于 user_list 同步标签成员
     */
    public static function addUserList(int $tag_id, array $user_list): void
    {
        foreach ($user_list as $user_id) {
            $user = User::withCorpId()->whereAccountId($user_id)->first();
            if ($user) {
                SyncService::addUserTagId($user, $tag_id);
            }
        }
    }

    /**
     * 基于 party_list 同步标签成员
     */
    public static function addPartyList(int $tag_id, array $party_list): void
    {
        $departmentIds = Department::withCorpId()->whereIn('department_id', $party_list)->get('id')->toArray();

        $users = User::withCorpId()->whereIn('department_id', $departmentIds)->get();
        foreach ($users as $user) {
            SyncService::addUserTagId($user, $tag_id);
        }
    }

    /**
     * 基于 user_list 同步标签成员
     */
    public static function delUserList(int $tag_id, array $user_list): void
    {
        $users = User::withCorpId()->whereIn('account_id', $user_list)->get();
        foreach ($users as $user) {
            SyncService::deleteUserTagId($user, $tag_id);
        }
    }

    /**
     * 基于 party_list 同步标签成员
     */
    public static function delByPartList(int $tag_id, array $party_list): void
    {
        $departmentIds = Department::withCorpId()->whereIn('department_id', $party_list)->get('id')->toArray();

        $users = User::withCorpId()->whereIn('department_id', $departmentIds)->get();
        foreach ($users as $user) {
            SyncService::deleteUserTagId($user, $tag_id);
        }
    }
}
