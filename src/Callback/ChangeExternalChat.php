<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback;

use Buqiu\EnterpriseWechat\Contracts\CallBackAbstract;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\GroupChat;
use Exception;
use Illuminate\Support\Str;

class ChangeExternalChat extends CallBackAbstract
{
    /**
     * 客户群创建事件
     *
     * @throws Exception
     */
    public function create(): void
    {
        EnterpriseWechatFacade::groupChat()->syncGet($this->data['chat_id']);
    }

    /**
     * 客户群变更事件
     *
     * @throws Exception
     */
    public function update(): void
    {
        $groupChatLib = EnterpriseWechatFacade::groupChat();

        $groupChat = GroupChat::withCorpId()->whereChatId($this->data['chat_id'])->withTrashed()->first();
        if (! $groupChat) {
            $groupChatLib->syncGet($this->data['chat_id']);

            return;
        }

        if ($this->data['is_change_member']) {
            if ($groupChat->member_version == $this->data['last_member_version']) {
                $groupChat->member_version = $this->data['last_member_version'];
                $groupChat->update(['member_version' => $this->data['last_member_version']]);
            } else {
                $groupChatLib->forceSyncList($this->data['chat_id']);

                return;
            }
        }

        $update_detail = Str::camel($this->data['update_detail']);

        $groupChatLib->$update_detail($this->data['chat_id'], $this->data['member_change_list']);
    }

    /**
     * 客户群解散事件
     *
     * @throws Exception
     */
    public function dismiss(): void
    {
        EnterpriseWechatFacade::groupChat()->dismiss($this->data['chat_id']);
    }
}
