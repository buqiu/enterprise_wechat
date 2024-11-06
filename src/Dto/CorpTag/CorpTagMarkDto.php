<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\CorpTag;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\User;

/**
 * 编辑客户企业标签
 *
 * @link https://developer.work.weixin.qq.com/document/path/92118
 */
class CorpTagMarkDto extends Dto
{
    public ?string $userid = null;

    public ?string $external_userid = null;

    public ?array $add_tag = [];

    public ?array $remove_tag = [];

    public function getUserId(): ?string
    {
        return $this->userid;
    }

    public function getUserKey()
    {
        $user = User::withCorpId()->whereAccountId($this->userid)->firstOrFail();

        return $user->getKey();
    }

    public function setUserid(?string $userid): void
    {
        $this->userid = $userid;
    }

    public function getExternalUserId(): ?string
    {
        return $this->external_userid;
    }

    public function setExternalUserid(?string $external_user_id): void
    {
        $this->external_userid = $external_user_id;
    }

    public function getAddTag(): array
    {
        return $this->add_tag ?? [];
    }

    public function setAddTag(?array $add_tag): void
    {
        $this->add_tag = $add_tag;
    }

    public function getRemoveTag(): array
    {
        return $this->remove_tag ?? [];
    }

    public function setRemoveTag(?array $remove_tag): void
    {
        $this->remove_tag = $remove_tag;
    }
}
