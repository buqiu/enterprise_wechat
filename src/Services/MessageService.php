<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\MessageDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Message;
use Exception;

class MessageService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): MessageDto
    {
        $messageDto = new MessageDto($data);
        $messageDto->setAgentId(EnterpriseWechatFacade::getCorp()->agent_id);

        return $messageDto;
    }

    /**
     * 发送应用消息
     *
     * @throws Exception
     */
    public static function send(MessageDto $messageDto): Message
    {
        return SyncService::appMessage($messageDto);
    }

    /**
     * 撤回应用消息
     *
     * @throws Exception
     */
    public static function recall(string $msg_id): void
    {
        $message = Message::withCorpId()->whereMsgType(Message::MSG_TYPE_APP)->whereMsgId($msg_id)->first();
        if (! $message) {
            return;
        }
        $message->recall_status = Message::RECALL_STATUS_YES;
        $message->save();
    }
}
