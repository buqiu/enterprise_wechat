<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\Message;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Buqiu\EnterpriseWechat\Utils\Utils;

class MessageDto extends Dto
{
    public ?string $touser = null;

    public ?string $toparty = null;

    public ?string $totag = null;

    public ?string $msgtype = null;

    public ?string $agentid = null;

    public ?int $safe = null;

    public ?int $enable_id_trans = null;

    public ?int $enable_duplicate_check = null;

    public ?int $duplicate_check_interval = null;

    public ?array $content = [];

    public ?string $msgid = null;

    public ?string $invaliduser = null;

    public ?string $invalidparty = null;

    public ?string $invalidtag = null;

    public ?string $unlicenseduser = null;

    public ?string $response_code = null;

    public function getToUser(): ?string
    {
        return $this->touser;
    }

    public function setToUser(?string $to_user): void
    {
        $this->touser = $to_user;
    }

    public function getToParty(): ?string
    {
        return $this->toparty;
    }

    public function setToParty(?string $to_party): void
    {
        $this->toparty = $to_party;
    }

    public function getToTag(): ?string
    {
        return $this->totag;
    }

    public function setToTag(?string $to_tag): void
    {
        $this->totag = $to_tag;
    }

    public function getMsgType(): ?string
    {
        return $this->msgtype;
    }

    public function setMsgType(?string $msg_type): void
    {
        $this->msgtype = $msg_type;
    }

    public function getAgentId(): ?string
    {
        return $this->agentid;
    }

    public function setAgentId(?string $agent_id): void
    {
        $this->agentid = $agent_id;
    }

    public function getSafe(): ?int
    {
        return $this->safe;
    }

    public function setSafe(?int $safe): void
    {
        $this->safe = $safe;
    }

    public function getEnableIdTrans(): ?int
    {
        return $this->enable_id_trans;
    }

    public function setEnableIdTrans(?int $enable_id_trans): void
    {
        $this->enable_id_trans = $enable_id_trans;
    }

    public function getEnableDuplicateCheck(): ?int
    {
        return $this->enable_duplicate_check;
    }

    public function setEnableDuplicateCheck(?int $enable_duplicate_check): void
    {
        $this->enable_duplicate_check = $enable_duplicate_check;
    }

    public function getDuplicateCheckInterval(): ?int
    {
        return $this->duplicate_check_interval;
    }

    public function setDuplicateCheckInterval(?int $duplicate_check_interval): void
    {
        $this->duplicate_check_interval = $duplicate_check_interval;
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

    public function getMsgId(): ?string
    {
        return $this->msgid;
    }

    public function setMsgId(?string $msg_id): void
    {
        $this->msgid = $msg_id;
    }

    public function getInvalidUser(): ?string
    {
        return $this->invaliduser;
    }

    public function setInvalidUser(?string $invalid_user): void
    {
        $this->invaliduser = $invalid_user;
    }

    public function getInvalidParty(): ?string
    {
        return $this->invalidparty;
    }

    public function setInvalidParty(?string $invalid_party): void
    {
        $this->invalidparty = $invalid_party;
    }

    public function getInvalidTag(): ?string
    {
        return $this->invalidtag;
    }

    public function setInvalidTag(?string $invalid_tag): void
    {
        $this->invalidtag = $invalid_tag;
    }

    public function getUnlicensedUser(): ?string
    {
        return $this->unlicenseduser;
    }

    public function setUnlicensedUser(?string $unlicensed_user): void
    {
        $this->unlicenseduser = $unlicensed_user;
    }

    public function getResponseCode(): ?string
    {
        return $this->response_code;
    }

    public function setResponseCode(?string $response_code): void
    {
        $this->response_code = $response_code;
    }

    public function getData(): array
    {
        return array_merge(parent::getData(), $this->getContent());
    }

    public function fill(Message $message): Message
    {
        if (Utils::notEmpty($this->getMsgId())) {
            $message->msg_id = $this->getMsgId();
        }
        if (Utils::notEmpty($this->getContent())) {
            $message->content = $this->getContent();
        }

        return $message;
    }
}
