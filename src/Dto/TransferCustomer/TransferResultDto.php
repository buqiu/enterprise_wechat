<?php

namespace Buqiu\EnterpriseWechat\Dto\TransferCustomer;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 客户接替状态
 */
class TransferResultDto extends Dto
{
    public ?string $handover_userid = null;

    public ?string $takeover_userid = null;

    public ?string $external_userid = null;

    public ?int $status = null;

    public ?int $takeover_time = null;

    public function getHandoverUserId(): ?string
    {
        return $this->handover_userid;
    }

    public function setHandoverUserId(?string $handover_user_id): void
    {
        $this->handover_userid = $handover_user_id;
    }

    public function getTakeoverUserId(): ?string
    {
        return $this->takeover_userid;
    }

    public function setTakeoverUserid(?string $takeover_user_id): void
    {
        $this->takeover_userid = $takeover_user_id;
    }

    public function getExternalUserId(): ?string
    {
        return $this->external_userid;
    }

    public function setExternalUserid(?string $external_user_id): void
    {
        $this->external_userid = $external_user_id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getTakeoverTime(): ?int
    {
        return $this->takeover_time;
    }

    public function setTakeoverTime(?int $takeover_time): void
    {
        $this->takeover_time = $takeover_time;
    }

    public function fill(TransferCustomer $transferCustomer): TransferCustomer
    {
        if (Utils::notEmpty($this->getHandoverUserId())) {
            $transferCustomer->handover_user_id = $this->getHandoverUserId();
        }
        if (Utils::notEmpty($this->getTakeoverUserId())) {
            $transferCustomer->takeover_user_id = $this->getTakeoverUserId();
        }
        if (Utils::notEmpty($this->getExternalUserId())) {
            $transferCustomer->external_user_id = $this->getExternalUserId();
        }
        if (Utils::notEmpty($this->getStatus())) {
            $transferCustomer->transfer_status = $this->getStatus();
        }
        if (Utils::notEmpty($this->getTakeoverTime())) {
            $transferCustomer->takeover_time = $this->getTakeoverTime();
        }

        return $transferCustomer;
    }
}