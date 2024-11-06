<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\CorpTag;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 企业标签组
 *
 * @link https://developer.work.weixin.qq.com/document/path/92117
 */
class CorpTagGroupDto extends Dto
{
    public ?string $group_id = null;

    public ?string $group_name = null;

    public ?int $create_time = null;

    public ?int $order = null;

    public ?array $tag = [];

    public function getGroupId(): ?string
    {
        return $this->group_id;
    }

    public function setGroupId(?string $group_id): void
    {
        $this->group_id = $group_id;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(?string $group_name): void
    {
        $this->group_name = $group_name;
    }

    public function getCreateTime(): ?int
    {
        return $this->create_time;
    }

    public function setCreateTime(?int $create_time): void
    {
        $this->create_time = $create_time;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
    }

    public function getTag(): ?array
    {
        return $this->tag ?? [];
    }

    public function setTag(?array $tag): void
    {
        $this->tag = $tag;
    }

    public function fill(CorpTag $corpTag): CorpTag
    {
        if (Utils::notEmpty($this->getGroupId())) {
            $corpTag->group_id = $this->getGroupId();
        }
        if (Utils::notEmpty($this->getGroupName())) {
            $corpTag->group_name = $this->getGroupName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $corpTag->group_create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $corpTag->group_order = $this->getOrder();
        }

        return $corpTag;
    }

    public function getModelData(): array
    {
        $data = [];
        if (Utils::notEmpty($this->getGroupId())) {
            $data['group_id'] = $this->getGroupId();
        }
        if (Utils::notEmpty($this->getGroupName())) {
            $data['group_name'] = $this->getGroupName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $data['group_create_time'] = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $data['group_order'] = $this->getOrder();
        }

        return $data;
    }
}
