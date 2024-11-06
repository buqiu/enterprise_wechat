<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Customer;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 外部联系人入参属性
 *
 * @link https://developer.work.weixin.qq.com/document/path/92994
 */
class ExternalContactDto extends Dto
{
    public ?string $external_userid = null;

    public ?string $name = null;

    public ?int $type = null;

    public ?string $avatar = null;

    public ?int $gender = null;

    public ?string $unionid = null;

    public ?string $position = null;

    public ?string $corp_name = null;

    public ?string $corp_full_name = null;

    public ?array $external_profile = [];

    public function getExternalUserId(): ?string
    {
        return $this->external_userid;
    }

    public function setExternalUserid(?string $external_user_id): void
    {
        $this->external_userid = $external_user_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): void
    {
        $this->gender = $gender;
    }

    public function getUnionId(): ?string
    {
        return $this->unionid;
    }

    public function setUnionId(?string $union_id): void
    {
        $this->unionid = $union_id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }

    public function getCorpName(): ?string
    {
        return $this->corp_name;
    }

    public function setCorpName(?string $corp_name): void
    {
        $this->corp_name = $corp_name;
    }

    public function getCorpFullName(): ?string
    {
        return $this->corp_full_name;
    }

    public function setCorpFullName(?string $corp_full_name): void
    {
        $this->corp_full_name = $corp_full_name;
    }

    public function getExternalProfile(): ?array
    {
        return $this->external_profile;
    }

    public function setExternalProfile(?array $external_profile): void
    {
        $this->external_profile = $external_profile;
    }

    public function fill(Customer $customer): Customer
    {
        if (Utils::notEmpty($this->getExternalUserId())) {
            $customer->external_user_id = $this->getExternalUserId();
        }
        if (Utils::notEmpty($this->getName())) {
            $customer->name = $this->getName();
        }
        if (Utils::notEmpty($this->getType())) {
            $customer->type = $this->getType();
        }
        if (Utils::notEmpty($this->getAvatar())) {
            $customer->avatar = $this->getAvatar();
        }
        if (Utils::notEmpty($this->getGender())) {
            $customer->gender = $this->getGender();
        }
        if (Utils::notEmpty($this->getUnionId())) {
            $customer->union_id = $this->getUnionId();
        }
        if (Utils::notEmpty($this->getPosition())) {
            $customer->position = $this->getPosition();
        }
        if (Utils::notEmpty($this->getCorpName())) {
            $customer->corp_name = $this->getCorpName();
        }
        if (Utils::notEmpty($this->getCorpFullName())) {
            $customer->corp_full_name = $this->getCorpFullName();
        }
        if (Utils::notEmpty($this->getExternalProfile())) {
            $customer->external_profile = $this->getExternalProfile();
        }

        return $customer;
    }
}
