<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagGroupDto;
use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 企业标签入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/92117
 */
class CorpTagDto extends Dto
{
    public ?string $id = null;

    public ?string $name = null;

    public ?int $create_time = null;

    public ?int $order = null;

    public ?bool $deleted = false;

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

    public function getDeleted(): ?bool
    {
        return $this->deleted ?? false;
    }

    public function setDeleted(?bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function fill(CorpTag $corpTag): CorpTag
    {
        if (Utils::notEmpty($this->getId())) {
            $corpTag->tag_id = $this->getId();
        }
        if (Utils::notEmpty($this->getName())) {
            $corpTag->name = $this->getName();
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $corpTag->create_time = $this->getCreateTime();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $corpTag->order = $this->getOrder();
        }

        return $corpTag;
    }

    public function convertGroup(): CorpTagGroupDto
    {
        $corpTagGroup = new CorpTagGroupDto;
        if (Utils::notEmpty($this->getId())) {
            $corpTagGroup->setGroupId($this->getId());
        }
        if (Utils::notEmpty($this->getName())) {
            $corpTagGroup->setGroupName($this->getName());
        }
        if (Utils::notEmpty($this->getCreateTime())) {
            $corpTagGroup->setCreateTime($this->getCreateTime());
        }
        if (Utils::notEmpty($this->getOrder())) {
            $corpTagGroup->setOrder($this->getOrder());
        }

        return $corpTagGroup;
    }
}
