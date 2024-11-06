<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Message;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Message;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Buqiu\EnterpriseWechat\Utils\Utils;

class BotDto extends Dto
{
    public ?string $msgtype = null;

    public ?array $content = [];

    protected ?string $key = null;

    public function getMsgType(): ?string
    {
        return $this->msgtype;
    }

    public function setMsgType(?string $msg_type): void
    {
        $this->msgtype = $msg_type;
    }

    public function getContent(): ?array
    {
        if (ArrHelper::isEmpty($this->params, $this->msgtype)) {
            return [];
        }

        return [
            $this->msgtype => $this->params[$this->msgtype],
        ];
    }

    public function setContent(?array $content): void
    {
        $this->content = $content;
    }

    public function getData(): array
    {
        return array_merge(parent::getData(), $this->getContent());
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    public function fill(Message $message): Message
    {
        if (Utils::notEmpty($this->getKey())) {
            $message->msg_key = $this->getKey();
        }

        if (Utils::notEmpty($this->getContent())) {
            $message->content = $this->getContent();
        }

        return $message;
    }
}
