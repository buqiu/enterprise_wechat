<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\TransferCustomer;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 分配在职成员的客户
 *
 * @link https://developer.work.weixin.qq.com/document/path/92125
 */
class TransferUserDto extends Dto
{
    public ?string $handover_userid = null;

    public ?string $takeover_userid = null;

    public ?string $transfer_success_msg = null;

    protected array $valid_require_property = [
        'handover_userid', 'takeover_userid',
    ];

    public function getHandoverUserId(): ?string
    {
        return $this->handover_userid;
    }

    public function setHandoverUserid(?string $handover_userid): void
    {
        $this->handover_userid = $handover_userid;
    }

    public function getTakeoverUserId(): ?string
    {
        return $this->takeover_userid;
    }

    public function setTakeoverUserid(?string $takeover_userid): void
    {
        $this->takeover_userid = $takeover_userid;
    }

    public function getTransferSuccessMsg(): ?string
    {
        return $this->transfer_success_msg;
    }

    public function setTransferSuccessMsg(?string $transfer_success_msg): void
    {
        $this->transfer_success_msg = $transfer_success_msg;
    }

    public function fill(TransferCustomer $transferCustomer): TransferCustomer
    {
        if (Utils::notEmpty($this->getHandoverUserId())) {
            $transferCustomer->handover_user_id = $this->getHandoverUserId();
        }
        if (Utils::notEmpty($this->getTakeoverUserId())) {
            $transferCustomer->takeover_user_id = $this->getTakeoverUserId();
        }
        if (Utils::notEmpty($this->getTransferSuccessMsg())) {
            $transferCustomer->transfer_success_msg = $this->getTransferSuccessMsg();
        }

        return $transferCustomer;
    }
}
