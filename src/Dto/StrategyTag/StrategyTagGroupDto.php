<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\StrategyTag;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\StrategyTag;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 企业标签组
 *
 * @link https://developer.work.weixin.qq.com/document/path/92117
 */
class StrategyTagGroupDto extends Dto
{
    public ?int $strategy_id = null;

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

    public function getStrategyId(): ?int
    {
        return $this->strategy_id;
    }

    public function setStrategyId(?int $strategy_id): void
    {
        $this->strategy_id = $strategy_id;
    }

    public function fill(StrategyTag $strategyTag): StrategyTag
    {
        if (Utils::notEmpty($this->getGroupId())) {
            $strategyTag->group_id = $this->getGroupId();
        }
        if (Utils::notEmpty($this->getGroupName())) {
            $strategyTag->group_name = $this->getGroupName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $strategyTag->group_create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $strategyTag->group_order = $this->getOrder();
        }

        return $strategyTag;
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
