<?php

namespace Buqiu\EnterpriseWechat\Dto\Message;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Message;
use Buqiu\EnterpriseWechat\Utils\Utils;

class GroupMessageDto extends Dto
{
    public ?string $msgid = null;

    public function getMsgId(): ?string
    {
        return $this->msgid;
    }

    public function setMsgId(?string $msg_id): void
    {
        $this->msgid = $msg_id;
    }

    public function fill(Message $message): Message
    {
        if (Utils::notEmpty($this->getMsgId())) {
            $message->msg_id = $this->getMsgId();
        }
        if (Utils::notEmpty($this->getParams())) {
            $message->content = $this->getParams();
        }

        return $message;
    }
}