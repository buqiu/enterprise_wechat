<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\GroupChatDto;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\GroupChat;
use Buqiu\EnterpriseWechat\Models\GroupChatMember;
use Buqiu\EnterpriseWechat\Utils\Utils;

class GroupChatMemberDto extends Dto
{
    public ?string $userid = null;

    public ?int $type = null;

    public ?int $join_time = null;

    public ?int $join_scene = null;

    public ?array $invitor = [];

    public ?string $group_nickname = null;

    public ?string $name = null;

    public ?string $unionid = null;

    public function getUserId(): ?string
    {
        return $this->userid;
    }

    public function setUserId(?string $user_id): void
    {
        $this->userid = $user_id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    public function getJoinTime(): ?int
    {
        return $this->join_time;
    }

    public function setJoinTime(?int $join_time): void
    {
        $this->join_time = $join_time;
    }

    public function getJoinScene(): ?int
    {
        return $this->join_scene;
    }

    public function setJoinScene(?int $join_scene): void
    {
        $this->join_scene = $join_scene;
    }

    public function getInvitor(): array
    {
        return $this->invitor ?? [];
    }

    public function getInvitorUserId(): string
    {
        $invitor = $this->getInvitor();

        return $invitor['userid'] ?? '';
    }

    public function setInvitor(?array $invitor): void
    {
        $this->invitor = $invitor;
    }

    public function getGroupNickname(): ?string
    {
        return $this->group_nickname;
    }

    public function setGroupNickname(?string $group_nickname): void
    {
        $this->group_nickname = $group_nickname;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getUnionid(): ?string
    {
        return $this->unionid;
    }

    public function setUnionid(?string $unionid): void
    {
        $this->unionid = $unionid;
    }

    public function fill(GroupChatMember $groupChatMember, array $admin_list): GroupChatMember
    {
        if (Utils::notEmpty($this->getType())) {
            $groupChatMember->type = $this->getType();
        }
        if (Utils::notEmpty($this->getUserId())) {
            $groupChatMember->user_id = $this->getUserId();
        }
        if (Utils::notEmpty($this->getUnionid())) {
            $groupChatMember->union_id = $this->getUnionid();
        }
        if (Utils::notEmpty($this->getJoinTime())) {
            $groupChatMember->join_time = $this->getJoinTime();
        }
        if (Utils::notEmpty($this->getJoinScene())) {
            $groupChatMember->join_scene = $this->getJoinScene();
        }
        if (Utils::notEmpty($this->getGroupNickname())) {
            $groupChatMember->group_nick_name = $this->getGroupNickname();
        }
        if (Utils::notEmpty($this->getName())) {
            $groupChatMember->name = $this->getName();
        }
        if (Utils::notEmpty($this->getInvitorUserId())) {
            $groupChatMember->invitor_user_id = $this->getInvitorUserId();
        }
        if (in_array($this->getUserId(), $admin_list)) {
            $groupChatMember->is_admin = GroupChatMember::IS_ADMIN;
        }

        return $groupChatMember;
    }
}
