<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\GroupChat;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

class GroupChatDto extends Dto
{
    public ?string $chat_id = null;

    public ?int $status = null;

    public ?string $name = null;

    public ?string $notice = null;

    public ?int $create_time = null;

    public ?array $member_list = [];

    public ?array $admin_list = [];

    public ?string $owner = null;

    public ?string $member_version = null;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getChatId(): ?string
    {
        return $this->chat_id;
    }

    public function setChatId(?string $chat_id): void
    {
        $this->chat_id = $chat_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCreateTime(): ?int
    {
        return $this->create_time;
    }

    public function setCreateTime(?int $create_time): void
    {
        $this->create_time = $create_time;
    }

    public function getMemberList(): ?array
    {
        return $this->member_list ?? [];
    }

    public function setMemberList(?array $member_list): void
    {
        $this->member_list = $member_list;
    }

    public function getAdminList(): array
    {
        return $this->admin_list ?? [];
    }

    public function setAdminList(?array $admin_list): void
    {
        $this->admin_list = $admin_list;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function getOwnerId(): ?string
    {
        $user = User::withCorpId()->whereAccountId($this->owner)->firstOrFail();

        return $user->getKey();
    }

    public function setOwner(?string $owner): void
    {
        $this->owner = $owner;
    }

    public function getMemberVersion(): ?string
    {
        return $this->member_version;
    }

    public function setMemberVersion(?string $member_version): void
    {
        $this->member_version = $member_version;
    }

    public function getNotice(): ?string
    {
        return $this->notice ?? '';
    }

    public function setNotice(?string $notice): void
    {
        $this->notice = $notice;
    }

    public function fill(GroupChat $groupChat): GroupChat
    {
        if (Utils::notEmpty($this->getChatId())) {
            $groupChat->chat_id = $this->getChatId();
        }
        if (Utils::notEmpty($this->getStatus())) {
            $groupChat->status = $this->getStatus();
        }
        if (Utils::notEmpty($this->getName())) {
            $groupChat->name = $this->getName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $groupChat->create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getNotice())) {
            $groupChat->notice = $this->getNotice();
        }
        if (Utils::notEmpty($this->getMemberVersion())) {
            $groupChat->member_version = $this->getMemberVersion();
        }
        if (Utils::notEmpty($this->getOwner())) {
            $groupChat->owner_id = $this->getOwnerId();
        }

        return $groupChat;
    }
}
