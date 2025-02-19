<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 部门属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/95351
 */
class DepartmentDto extends Dto
{
    public ?string $name = null;

    public ?string $name_en = null;

    public ?int $parentid = null;

    public ?int $order = null;

    public ?int $id = null;

    public ?array $department_leader = [];

    protected ?array $path = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getNameEn(): ?string
    {
        return $this->name_en;
    }

    public function setNameEn(?string $name_en): void
    {
        $this->name_en = $name_en;
    }

    public function getParentid(): ?int
    {
        return $this->parentid;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parentid = $parent_id;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDepartmentLeader(): array
    {
        return $this->department_leader ?? [];
    }

    public function setDepartmentLeader(array $department_leader): void
    {
        $this->department_leader = $department_leader;
    }

    public function getPath(): ?array
    {
        return $this->path ?? [];
    }

    public function setPath(?array $path): void
    {
        $this->path = $path;
    }

    public function fill(Department $department): Department
    {
        if (Utils::notEmpty($this->getId())) {
            $department->department_id = $this->getId();
        }
        if (Utils::notEmpty($this->getName())) {
            $department->name = $this->getName();
        }
        if (Utils::notEmpty($this->getNameEn())) {
            $department->name_en = $this->getNameEn();
        }
        if ($this->issetParam('department_leader')) {
            $department->department_leader = $this->getDepartmentLeader();
        }
        if ($this->issetParam('parentid')) {
            $department->parent_id = $this->getParentid();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $department->order = $this->getOrder();
        }
        if (Utils::notEmpty($this->getPath())) {
            $department->path = $this->getPath();
        }

        return $department;
    }
}
