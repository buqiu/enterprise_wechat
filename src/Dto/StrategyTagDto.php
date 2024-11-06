<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Dto\StrategyTag\StrategyTagGroupDto;
use Buqiu\EnterpriseWechat\Models\StrategyTag;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 企业标签入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/92117
 */
class StrategyTagDto extends Dto
{
    public ?string $id = null;

    public ?string $name = null;

    public ?int $create_time = null;

    public ?int $order = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
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

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
    }

    public function fill(StrategyTag $strategyTag): StrategyTag
    {
        if (Utils::notEmpty($this->getId())) {
            $strategyTag->tag_id = $this->getId();
        }
        if (Utils::notEmpty($this->getName())) {
            $strategyTag->name = $this->getName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $strategyTag->create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $strategyTag->order = $this->getOrder();
        }

        return $strategyTag;
    }

    public function convertGroup(): StrategyTagGroupDto
    {
        $strategyTagGroupDto = new StrategyTagGroupDto;
        if (Utils::notEmpty($this->getId())) {
            $strategyTagGroupDto->setGroupId($this->getId());
        }
        if (Utils::notEmpty($this->getName())) {
            $strategyTagGroupDto->setGroupName($this->getName());
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $strategyTagGroupDto->setCreateTime($this->getCreateTime());
        }
        if (Utils::notEmpty($this->getOrder())) {
            $strategyTagGroupDto->setOrder($this->getOrder());
        }

        return $strategyTagGroupDto;
    }
}
