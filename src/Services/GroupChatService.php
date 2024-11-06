<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\GroupChatDto;
use Buqiu\EnterpriseWechat\Dto\GroupChatDto\GroupChatMemberDto;
use Buqiu\EnterpriseWechat\Dto\GroupChatDto\GroupChatTransferDto;
use Buqiu\EnterpriseWechat\Models\GroupChat;
use Buqiu\EnterpriseWechat\Models\GroupChatMember;
use Exception;

class GroupChatService
{
    /**
     * 同步客户群列表
     *
     * @throws Exception
     */
    public static function syncList(GroupChatDto $groupChatDto): void
    {
        foreach ($groupChatDto->getMemberList() as $groupMember) {
            SyncService::groupChat($groupChatDto);
            SyncService::groupChatMember($groupChatDto, new GroupChatMemberDto($groupMember));
        }
    }

    /**
     * 强制同步客户群成员列表
     *
     * @throws Exception
     */
    public static function forceSyncList(GroupChatDto $groupChatDto): void
    {
        $groupChatMemberIds = [];
        foreach ($groupChatDto->getMemberList() as $groupMember) {
            SyncService::groupChat($groupChatDto);
            $groupChatMember = SyncService::groupChatMember($groupChatDto, new GroupChatMemberDto($groupMember));

            $groupChatMemberIds[] = $groupChatMember->getKey();
        }
        GroupChatMember::withCorpId()->whereChatId($groupChatDto->getChatId())->whereNotIn('id', $groupChatMemberIds)->delete();
    }

    /**
     * 删除群成员
     */
    public static function delEntity(GroupChatDto $groupChatDto, GroupChatMemberDto $groupChatMemberDto): void
    {
        $groupChatMember = GroupChatMember::withCorpId()->whereChatId($groupChatDto->getChatId())->whereMemberUserId($groupChatMemberDto->getUserId())->withTrashed()->first();
        if (! $groupChatMember) {
            return;
        }
        $groupChatMember->delete();
    }

    /**
     * 群公告变更
     *
     * @throws Exception
     */
    public static function changeNotice(GroupChatDto $groupChatDto): void
    {
        GroupChat::withCorpId()->whereChatId($groupChatDto->getChatId())->update(['notice' => $groupChatDto->getNotice()]);
    }

    /**
     * 群名变更
     *
     * @throws Exception
     */
    public static function changeName(GroupChatDto $groupChatDto): void
    {
        GroupChat::withCorpId()->whereChatId($groupChatDto->getChatId())->update(['name' => $groupChatDto->getName()]);
    }

    /**
     * 群主变更
     *
     * @throws Exception
     */
    public static function changeOwner(GroupChatDto $groupChatDto): void
    {
        GroupChat::withCorpId()->whereChatId($groupChatDto->getChatId())->update(['owner_id' => $groupChatDto->getOwnerId()]);
    }

    /**
     * 成员入群
     *
     * @throws Exception
     */
    public static function addMember(GroupChatDto $groupChatDto, array $member_list): void
    {
        foreach ($groupChatDto->getMemberList() as $groupMember) {
            $groupChatMemberDto = new GroupChatMemberDto($groupMember);
            if (in_array($groupChatMemberDto->getUserId(), $member_list)) {
                continue;
            }
            SyncService::groupChatMember($groupChatDto, $groupChatMemberDto);
        }
    }

    /**
     * 成员退群
     *
     * @throws Exception
     */
    public static function delMember(GroupChatDto $groupChatDto, array $member_list): void
    {
        foreach ($groupChatDto->getMemberList() as $groupMember) {
            $groupChatMemberDto = new GroupChatMemberDto($groupMember);
            if (! in_array($groupChatMemberDto->getUserId(), $member_list)) {
                continue;
            }
            GroupChatService::delEntity($groupChatDto, $groupChatMemberDto);
        }
    }

    /**
     * 解散客户群
     */
    public static function dismiss(string $wechat_id): void
    {
        GroupChat::withCorpId()->whereChatId($wechat_id)->delete();
        GroupChatMember::withCorpId()->whereChatId($wechat_id)->delete();
    }

    /**
     * 分配客户群
     *
     * @throws Exception
     */
    public static function transfer(string $new_owner, array $chat_id_list, array $failed_chat_list): void
    {
        $failed_chat_list = collect($failed_chat_list);
        foreach ($chat_id_list as $chat_id) {
            $groupChatTransferDto = new GroupChatTransferDto(compact('new_owner', 'chat_id'));
            $failed_chat          = $failed_chat_list->firstWhere('chat_id', $chat_id);
            if ($failed_chat) {
                $groupChatTransferDto->setData($failed_chat);
            } else {
                SyncService::modifyGroupChatOwner($new_owner, $chat_id);
            }
            SyncService::groupChatTransfer($groupChatTransferDto);
        }
    }

    /**
     * 分配在职成员的客户群
     *
     * @throws Exception
     */
    public static function onJobTransfer(string $new_owner, array $chat_id_list, array $failed_chat_list): void
    {
        GroupChatService::transfer($new_owner, $chat_id_list, $chat_id_list);
    }

    /**
     * 分配离职成员的客户群
     *
     * @throws Exception
     */
    public static function resignedTransfer(string $new_owner, array $chat_id_list, array $failed_chat_list): void
    {
        GroupChatService::transfer($new_owner, $chat_id_list, $chat_id_list);
    }
}
