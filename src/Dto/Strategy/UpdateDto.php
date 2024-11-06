<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Strategy;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Strategy;
use Buqiu\EnterpriseWechat\Utils\Utils;

class UpdateDto extends Dto
{
    public ?int $strategy_id = null;

    public ?int $parent_id = null;

    public ?string $strategy_name = null;

    public ?int $create_time = null;

    public ?array $admin_list = [];

    public ?array $privilege = [];

    public ?array $range_add = [];

    public ?array $range_del = [];

    public function getRangeAdd(): ?array
    {
        return $this->range_add;
    }

    public function setRangeAdd(?array $range_add): void
    {
        $this->range_add = $range_add;
    }

    public function getRangeDel(): ?array
    {
        return $this->range_del;
    }

    public function setRangeDel(?array $range_del): void
    {
        $this->range_del = $range_del;
    }

    public function getStrategyId(): ?int
    {
        return $this->strategy_id;
    }

    public function setStrategyId(?int $strategy_id): void
    {
        $this->strategy_id = $strategy_id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    public function getStrategyName(): ?string
    {
        return $this->strategy_name;
    }

    public function setStrategyName(?string $strategy_name): void
    {
        $this->strategy_name = $strategy_name;
    }

    public function getCreateTime(): ?int
    {
        return $this->create_time;
    }

    public function setCreateTime(?int $create_time): void
    {
        $this->create_time = $create_time;
    }

    public function getAdminList(): ?array
    {
        return $this->admin_list;
    }

    public function setAdminList(?array $admin_list): void
    {
        $this->admin_list = $admin_list;
    }

    public function getPrivilege(): ?array
    {
        return $this->privilege;
    }

    public function setPrivilege(?array $privilege): void
    {
        $this->privilege = $privilege;
    }

    public function fill(Strategy $strategy): Strategy
    {
        if (Utils::notEmpty($this->getStrategyName())) {
            $strategy->strategy_name = $this->getStrategyName();
        }
        if (Utils::notEmpty($this->getAdminList())) {
            $strategy->admin_list = $this->getAdminList();
        }
        if (Utils::notEmpty($this->getPrivilege())) {
            $strategy->privilege = $this->getPrivilege();
        }

        return $strategy;
    }
}
