<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\ContactWay;
use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 配置客户联系方式入参属性
 *
 * @link https://developer.work.weixin.qq.com/document/path/92228
 */
class ContactWayDto extends Dto
{
    public ?int $type = null;

    public ?int $scene = null;

    public ?int $style = null;

    public ?string $remark = null;

    public ?bool $skip_verify = null;

    public ?string $state = null;

    public ?array $user = null;

    public ?array $party = null;

    public ?bool $is_temp = null;

    public ?int $expires_in = null;

    public ?int $chat_expires_in = null;

    public ?string $unionid = null;

    public ?bool $is_exclusive = null;

    public ?array $conclusions = null;

    public ?string $config_id = null;

    public ?string $qr_code = null;

    public ?array $user_id = null;

    public ?array $department_id = null;

    public function getDepartmentId(): ?array
    {
        if (empty($this->party)) {
            return [];
        }
        return Department::withCorpId()->whereIn('department_id', $this->party)->pluck('id')->toArray();
    }

    public function getUserId(): ?array
    {
        if (empty($this->user)) {
            return [];
        }
        return User::withCorpId()->whereIn('account_id', $this->user)->pluck('id')->toArray();
    }

    /**
     * 获取属性值
     */
    public function __get(string $name)
    {
    }

    /**
     * 设置属性值
     */
    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function fill(ContactWay $contactWay): ContactWay
    {
        $this->fillProperty($contactWay, 'type');
        $this->fillProperty($contactWay, 'scene');
        $this->fillProperty($contactWay, 'style');
        $this->fillProperty($contactWay, 'remark');
        $this->fillProperty($contactWay, 'skip_verify', false);
        $this->fillProperty($contactWay, 'state');
        $this->fillProperty($contactWay, 'is_temp', false);
        $this->fillProperty($contactWay, 'expires_in');
        $this->fillProperty($contactWay, 'chat_expires_in');
        $this->fillProperty($contactWay, 'unionid');
        $this->fillProperty($contactWay, 'is_exclusive', false);
        $this->fillProperty($contactWay, 'conclusions');
        $this->fillProperty($contactWay, 'config_id');
        $this->fillProperty($contactWay, 'qr_code');

        if (Utils::notEmpty($this->party)) {
            $contactWay->department_id = $this->getDepartmentId();
        }

        if (Utils::notEmpty($this->user)) {
            $contactWay->user_id = $this->getUserId();
        }

        return $contactWay;
    }

    /**
     * 统一填充属性的方法
     */
    private function fillProperty(ContactWay $contactWay, string $property, bool $checkEmpty = true): void
    {
        if ($checkEmpty ? Utils::notEmpty($this->$property) : isset($this->params[$property])) {
            $contactWay->$property = $this->$property;
        }
    }
}
