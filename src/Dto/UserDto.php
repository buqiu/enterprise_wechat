<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 成员属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90201
 */
class UserDto extends Dto
{
    public ?string $userid = null;

    public ?string $name = null;

    public ?string $mobile = null;

    public ?array $department = [];

    public ?array $order = [];

    public ?string $position = null;

    public ?string $gender = null;

    public ?string $email = null;

    public ?string $biz_mail = null;

    public ?array $is_leader_in_dept = [];

    public ?array $direct_leader = [];

    public ?string $avatar = null;

    public ?string $thumb_avatar = null;

    public ?string $telephone = null;

    public ?string $alias = null;

    public array $extattr = [];

    public ?int $status = null;

    public ?string $qr_code = null;

    public ?array $external_profile = [];

    public ?string $external_position = null;

    public ?string $address = null;

    public ?string $open_userid = null;

    public ?int $main_department = null;

    public function getUserId(): ?string
    {
        return $this->userid;
    }

    public function setUserId(?string $user_id): void
    {
        $this->userid = $user_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }

    public function getDepartment(): array
    {
        return $this->department ?? [];
    }

    public function getDepartmentKey(): ?string
    {
        $departmentIds = $this->getDepartment();
        $departmentId  = end($departmentIds) ?: null;
        return $departmentId ? object_get(Department::withCorpId()->whereDepartmentId($departmentId)->first(), 'id', '') : '';
    }

    public function setDepartment(array $department): void
    {
        $this->department = $department;
    }

    public function getOrder(): array
    {
        return $this->order ?? [];
    }

    public function setOrder(array $order): void
    {
        $this->order = $order;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getBizMail(): ?string
    {
        return $this->biz_mail;
    }

    public function setBizMail(?string $biz_mail): void
    {
        $this->biz_mail = $biz_mail;
    }

    public function getIsLeaderInDept(): array
    {
        return $this->is_leader_in_dept ?? [];
    }

    public function setIsLeaderInDept(array $is_leader_in_dept): void
    {
        $this->is_leader_in_dept = $is_leader_in_dept;
    }

    public function getDirectLeader(): array
    {
        return $this->direct_leader ?? [];
    }

    public function setDirectLeader(array $direct_leader): void
    {
        $this->direct_leader = $direct_leader;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getThumbAvatar(): ?string
    {
        return $this->thumb_avatar;
    }

    public function setThumbAvatar(?string $thumb_avatar): void
    {
        $this->thumb_avatar = $thumb_avatar;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }

    public function getExtAttr(): array
    {
        return $this->extattr ?? [];
    }

    public function setExtAttr(array $ext_attr): void
    {
        $this->extattr = $ext_attr;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getQrCode(): ?string
    {
        return $this->qr_code;
    }

    public function setQrCode(?string $qr_code): void
    {
        $this->qr_code = $qr_code;
    }

    public function getExternalProfile(): array
    {
        return $this->external_profile ?? [];
    }

    public function setExternalProfile(array $external_profile): void
    {
        $this->external_profile = $external_profile;
    }

    public function getExternalPosition(): ?string
    {
        return $this->external_position;
    }

    public function setExternalPosition(?string $external_position): void
    {
        $this->external_position = $external_position;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getOpenUserid(): ?string
    {
        return $this->open_userid;
    }

    public function setOpenUserid(?string $open_userid): void
    {
        $this->open_userid = $open_userid;
    }

    public function getMainDepartment(): ?int
    {
        return $this->main_department;
    }

    public function setMainDepartment(?int $main_department): void
    {
        $this->main_department = $main_department;
    }

    public function fill(User $user): User
    {
        if (Utils::notEmpty($this->getUserId())) {
            $user->account_id = $this->getUserId();
        }
        if (Utils::notEmpty($this->getName())) {
            $user->name = $this->getName();
        }
        if (Utils::notEmpty($this->getMobile())) {
            $user->mobile = $this->getMobile();
        }
        if (Utils::notEmpty($this->getDepartment())) {
            $user->department_id = $this->getDepartmentKey();
        }
        if (Utils::notEmpty($this->getOrder())) {
            $orders      = $this->getOrder();
            $user->order = end($orders) ?: 0;
        }
        if (Utils::notEmpty($this->getPosition())) {
            $user->position = $this->getPosition();
        }
        if (Utils::notEmpty($this->getGender())) {
            $user->gender = $this->getGender();
        }
        if (Utils::notEmpty($this->getEmail())) {
            $user->email = $this->getEmail();
        }
        if (Utils::notEmpty($this->getBizMail())) {
            $user->biz_mail = $this->getBizMail();
        }
        if ($this->issetParam('is_leader_in_dept')) {
            $user->is_leader_in_dept = $this->getIsLeaderInDept();
        }
        if ($this->issetParam('direct_leader')) {
            $user->direct_leader = $this->getDirectLeader();
        }
        if (Utils::notEmpty($this->getAvatar())) {
            $user->avatar = $this->getAvatar();
        }
        if (Utils::notEmpty($this->getThumbAvatar())) {
            $user->thumb_avatar = $this->getThumbAvatar();
        }
        if (Utils::notEmpty($this->getTelephone())) {
            $user->telephone = $this->getTelephone();
        }
        if (Utils::notEmpty($this->getAlias())) {
            $user->alias = $this->getAlias();
        }
        if (Utils::notEmpty($this->getExtAttr())) {
            $user->ext_attr = $this->getExtAttr();
        }
        if (Utils::notEmpty($this->getStatus())) {
            $user->status = $this->getStatus();
        }
        if (Utils::notEmpty($this->getQrCode())) {
            $user->qr_code = $this->getQrCode();
        }
        if (Utils::notEmpty($this->getExternalProfile())) {
            $user->external_profile = $this->getExternalProfile();
        }
        if (Utils::notEmpty($this->getExternalPosition())) {
            $user->external_position = $this->getExternalPosition();
        }
        if (Utils::notEmpty($this->getAddress())) {
            $user->address = $this->getAddress();
        }
        if (Utils::notEmpty($this->getOpenUserid())) {
            $user->open_userid = $this->getOpenUserid();
        }

        return $user;
    }
}
