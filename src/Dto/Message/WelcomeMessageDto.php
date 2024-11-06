<?php

namespace Buqiu\EnterpriseWechat\Dto\Message;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Message;
use Buqiu\EnterpriseWechat\Utils\Utils;

class WelcomeMessageDto extends Dto
{
    public ?string $welcome_code = null;

    public function getWelcomeCode(): ?string
    {
        return $this->welcome_code;
    }

    public function setWelcomeCode(?string $welcome_code): void
    {
        $this->welcome_code = $welcome_code;
    }

    public function fill(Message $message): Message
    {
        if (Utils::notEmpty($this->getWelcomeCode())) {
            $message->welcome_code = $this->getWelcomeCode();
        }
        if (Utils::notEmpty($this->getParams())) {
            $message->content = $this->getParams();
        }

        return $message;
    }
}