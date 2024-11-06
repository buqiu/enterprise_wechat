<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\GroupChatDto;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\TransferGroupChat;
use Buqiu\EnterpriseWechat\Utils\Utils;

class GroupChatTransferDto extends Dto
{
    public ?string $new_owner = null;

    public ?string $chat_id = null;

    public ?int $errcode = null;

    public ?string $errmsg = null;

    public function getChatId(): ?string
    {
        return $this->chat_id;
    }

    public function setChatId(?string $chat_id): void
    {
        $this->chat_id = $chat_id;
    }

    public function getErrCode(): ?int
    {
        return $this->errcode;
    }

    public function setErrCode(?int $err_code): void
    {
        $this->errcode = $err_code;
    }

    public function getErrMsg(): ?string
    {
        return $this->errmsg;
    }

    public function setErrMsg(?string $err_msg): void
    {
        $this->errmsg = $err_msg;
    }

    public function getNewOwner(): ?string
    {
        return $this->new_owner;
    }

    public function setNewOwner(?string $new_owner): void
    {
        $this->new_owner = $new_owner;
    }

    public function fill(TransferGroupChat $transferGroupChat): TransferGroupChat
    {
        if (Utils::notEmpty($this->getChatId())) {
            $transferGroupChat->chat_id = $this->getChatId();
        }
        if (Utils::notEmpty($this->getNewOwner())) {
            $transferGroupChat->new_user_id = $this->getNewOwner();
        }
        if (Utils::notEmpty($this->getErrCode())) {
            $transferGroupChat->transfer_err_code = $this->getErrCode();
        }
        if (Utils::notEmpty($this->getErrMsg())) {
            $transferGroupChat->transfer_err_msg = $this->getErrMsg();
        }

        return $transferGroupChat;
    }
}
