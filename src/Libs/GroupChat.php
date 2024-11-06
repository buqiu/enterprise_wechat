<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Dto\GroupChatDto;
use Buqiu\EnterpriseWechat\Services\GroupChatService;
use Exception;

class GroupChat extends Lib
{
    /**
     * 同步客户群列表
     *
     * @throws Exception
     */
    public function syncList(): void
    {
        $cursor = null;
        do {
            [$cursor, $group_chat_list] = $this->api->list(compact('cursor'));
            foreach ($group_chat_list as $group_chat) {
                $groupChat = new GroupChatDto($group_chat);
                GroupChatService::syncList($groupChat->setData($this->api->get($groupChat->getChatId())));
            }
        } while ($cursor);
    }

    /**
     * 同步客户群详情
     *
     * @throws Exception
     */
    public function syncGet(string $wechat_id): void
    {
        GroupChatService::syncList(new GroupChatDto($this->api->get($wechat_id)));
    }

    /**
     * 强同步客户群列表
     *
     * @throws Exception
     */
    public function forceSyncList(string $wechat_id): void
    {
        GroupChatService::forceSyncList(new GroupChatDto($this->api->get($wechat_id)));
    }

    /**
     * 群公告变更
     *
     * @throws Exception
     */
    public function changeNotice(string $wechat_id): void
    {
        GroupChatService::changeNotice(new GroupChatDto($this->api->get($wechat_id)));
    }

    /**
     * 群名变更
     *
     * @throws Exception
     */
    public function changeName(string $wechat_id): void
    {
        GroupChatService::changeName(new GroupChatDto($this->api->get($wechat_id)));
    }

    /**
     * 群主变更
     *
     * @throws Exception
     */
    public function changeOwner(string $wechat_id): void
    {
        GroupChatService::changeOwner(new GroupChatDto($this->api->get($wechat_id)));
    }

    /**
     * 成员入群
     *
     * @throws Exception
     */
    public function addMember(string $wechat_id, array $member_list): void
    {
        GroupChatService::addMember(new GroupChatDto($this->api->get($wechat_id)), $member_list);
    }

    /**
     * 成员退群
     *
     * @throws Exception
     */
    public function delMember(string $wechat_id, array $member_list): void
    {
        GroupChatService::delMember(new GroupChatDto($this->api->get($wechat_id)), $member_list);
    }

    /**
     * 解散客户群
     */
    public function dismiss(string $wechat_id): void
    {
        GroupChatService::dismiss($wechat_id);
    }

    /**
     * 分配在职成员的客户群
     *
     * @throws Exception
     */
    public function onJobTransfer(string $new_owner, array $chat_id_list): array
    {
        $failedChatList = $this->api->onJobTransfer($new_owner, $chat_id_list);

        GroupChatService::onJobTransfer($new_owner, $chat_id_list, $failedChatList);

        return $failedChatList;
    }

    /**
     * 分配离职成员的客户群
     *
     * @throws Exception
     */
    public function resignedTransfer(string $new_owner, array $chat_id_list): array
    {
        $failedChatList = $this->api->resignedTransfer($new_owner, $chat_id_list);

        GroupChatService::resignedTransfer($new_owner, $chat_id_list, $failedChatList);

        return $failedChatList;
    }
}
