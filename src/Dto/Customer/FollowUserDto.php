<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Customer;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 成员添加外部客户入参属性
 *
 * @link https://developer.work.weixin.qq.com/document/path/92994
 */
class FollowUserDto extends Dto
{
    public ?string $userid = null;

    public ?string $remark = null;

    public ?string $description = null;

    public ?int $createtime = null;

    public ?array $tag_id = [];

    public ?string $remark_corp_name = null;

    public ?array $remark_mobiles = [];

    public ?int $add_way = null;

    public ?string $operate_userid = null;

    public ?array $wechat_channels = [];

    public ?array $tags = [];

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

    public function getCreateTime(): ?int
    {
        return $this->createtime;
    }

    public function setCreateTime(?int $create_time): void
    {
        $this->createtime = $create_time;
    }

    public function getTagId(): ?array
    {
        return $this->tag_id;
    }

    public function setTagId(?array $tag_id): void
    {
        $this->tag_id = $tag_id ?? [];
    }

    public function getRemarkCorpName(): ?string
    {
        return $this->remark_corp_name;
    }

    public function setRemarkCorpName(?string $remark_corp_name): void
    {
        $this->remark_corp_name = $remark_corp_name;
    }

    public function getRemarkMobiles(): ?array
    {
        return $this->remark_mobiles ?? [];
    }

    public function setRemarkMobiles(?array $remark_mobiles): void
    {
        $this->remark_mobiles = $remark_mobiles;
    }

    public function getAddWay(): ?int
    {
        return $this->add_way;
    }

    public function setAddWay(?int $add_way): void
    {
        $this->add_way = $add_way;
    }

    public function getOperateUserid(): ?string
    {
        return $this->operate_userid;
    }

    public function setOperateUserid(?string $operate_userid): void
    {
        $this->operate_userid = $operate_userid;
    }

    public function getWechatChannels(): ?array
    {
        return $this->wechat_channels ?? [];
    }

    public function setWechatChannels(?array $wechat_channels): void
    {
        $this->wechat_channels = $wechat_channels;
    }

    public function getTags(): array
    {
        return $this->tags ?? [];
    }

    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }

    public function fill(Customer $customer): Customer
    {
        if (Utils::notEmpty($this->getUserId())) {
            $customer->user_id = $this->getUserKey();
        }
        if (Utils::notEmpty($this->getRemark())) {
            $customer->remark = $this->getRemark();
        }
        if (Utils::notEmpty($this->getDescription())) {
            $customer->description = $this->getDescription();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $customer->create_time = $this->getCreateTime();
        }
        if ($this->issetParam('tag_id')) {
            $customer->tag_ids = $this->getTagId();
        }
        if ($this->issetParam('tags')) {
            $customer->tag_ids = array_column($this->getTags(), 'tag_id');
        }
        if (Utils::notEmpty($this->getRemarkCorpName())) {
            $customer->remark_company = $this->getRemarkCorpName();
        }
        if (Utils::notEmpty($this->getRemarkMobiles())) {
            $customer->remark_mobiles = $this->getRemarkMobiles();
        }
        if (Utils::notEmpty($this->getAddWay())) {
            $customer->add_way = $this->getAddWay();
        }
        if (Utils::notEmpty($this->getOperateUserid())) {
            $customer->operate_userid = $this->getOperateUserid();
        }
        if (Utils::notEmpty($this->getWechatChannels())) {
            $customer->wechat_channels = $this->getWechatChannels();
        }

        return $customer;
    }
}
