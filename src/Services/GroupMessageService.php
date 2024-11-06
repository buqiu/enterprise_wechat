<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Message\GroupMessageDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Message;
use Exception;

class GroupMessageService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): GroupMessageDto
    {
        return new GroupMessageDto($data);
    }

    /**
     * 发送应用消息
     *
     * @throws Exception
     */
    public static function send(GroupMessageDto $messageDto): void
    {
        SyncService::groupMessage($messageDto);
    }

    /**
     * 撤回应用消息
     *
     * @throws Exception
     */
    public static function cancel(string $msg_id): void
    {
        $message = Message::withCorpId()->whereMsgType(Message::MSG_TYPE_GROUP)->whereMsgId($msg_id)->first();
        if (! $message) {
            return;
        }
        $message->recall_status = Message::RECALL_STATUS_YES;
        $message->save();
    }
}
