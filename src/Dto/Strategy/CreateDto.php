<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Strategy;

use Buqiu\EnterpriseWechat\Dto\StrategyDto;
use Buqiu\EnterpriseWechat\Models\Strategy;
use Buqiu\EnterpriseWechat\Utils\Utils;

class CreateDto extends StrategyDto
{
    public ?int $strategy_id = null;

    public ?int $parent_id = null;

    public ?string $strategy_name = null;

    public ?int $create_time = null;

    public ?array $admin_list = [];

    public ?array $privilege = [];

    public ?array $range = [];

    public ?array $range_user = [];

    public ?array $range_party = [];

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
        return time();
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

    public function getRange(): ?array
    {
        return $this->range;
    }

    public function setRange(?array $range): void
    {
        $this->range = $range;
    }

    public function getRangeUser(): ?array
    {
        return $this->range_user;
    }

    public function setRangeUser(?array $range_user): void
    {
        $this->range_user = $range_user;
    }

    public function getRangeParty(): ?array
    {
        return $this->range_party;
    }

    public function setRangeParty(?array $range_party): void
    {
        $this->range_party = $range_party;
    }

    public function fill(Strategy $strategy): Strategy
    {
        if (Utils::notEmpty($this->getCreateTime())) {
            $strategy->create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getStrategyId())) {
            $strategy->strategy_id = $this->getStrategyId();
        }
        if (Utils::notEmpty($this->getParentId())) {
            $strategy->parent_id = $this->getParentId();
        }
        if (Utils::notEmpty($this->getStrategyName())) {
            $strategy->strategy_name = $this->getStrategyName();
        }
        if (Utils::notEmpty($this->getRangeUser())) {
            $strategy->range_user = $this->getRangeUser();
        }
        if (Utils::notEmpty($this->getRangeParty())) {
            $strategy->range_party = $this->getRangeParty();
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
