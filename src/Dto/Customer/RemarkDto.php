<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Customer;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 修改客户备注入参属性
 *
 * @link https://developer.work.weixin.qq.com/document/path/92115
 */
class RemarkDto extends Dto
{
    public ?string $userid = null;

    public ?string $external_userid = null;

    public ?string $remark = null;

    public ?string $description = null;

    public ?string $remark_company = null;

    public array|string|null $remark_mobiles = null;

    protected array $valid_require_property = [
        'userid', 'external_userid',
    ];

    public function getUserId(): ?string
    {
        return $this->userid;
    }

    public function getUserKey()
    {
        $user = User::withCorpId()->whereAccountId($this->userid)->firstOrFail();

        return $user->getKey();
    }

    public function setUserId(?string $user_id): void
    {
        $this->userid = $user_id;
    }

    public function getExternalUserId(): ?string
    {
        return $this->external_userid;
    }

    public function setExternalUserid(?string $external_user_id): void
    {
        $this->external_userid = $external_user_id;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): void
    {
        $this->remark = $remark;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getRemarkCompany(): ?string
    {
        return $this->remark_company;
    }

    public function setRemarkCompany(?string $remark_company): void
    {
        $this->remark_company = $remark_company;
    }

    public function getRemarkMobiles(): array|string|null
    {
        return $this->remark_mobiles;
    }

    public function setRemarkMobiles(array|string|null $remark_mobiles): void
    {
        $this->remark_mobiles = $remark_mobiles;
    }

    public function fill(Customer $customer): Customer
    {
        if (Utils::notEmpty($this->getUserId())) {
            $customer->user_id = $this->getUserKey();
        }
        if (Utils::notEmpty($this->getExternalUserId())) {
            $customer->external_user_id = $this->getExternalUserId();
        }
        if ($this->issetParam('remark')) {
            $customer->remark = Utils::notEmpty($this->getRemark()) ? $this->getRemark() : $customer->name;
        }
        if ($this->issetParam('description')) {
            $customer->description = $this->getDescription();
        }
        if ($this->issetParam('remark_company')) {
            $customer->remark_company = $this->getRemarkCompany();
        }
        if ($this->issetParam('remark_mobiles')) {
            $customer->remark_mobiles = $this->getRemarkMobiles();
        }

        return $customer;
    }
}
