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
class TransferCustomerDto extends Dto
{
    public ?string $external_userid = null;

    public ?int $errcode = null;

    public function getExternalUserId(): ?string
    {
        return $this->external_userid;
    }

    public function setExternalUserId(?string $external_user_id): void
    {
        $this->external_userid = $external_user_id;
    }

    public function getErrCode(): ?int
    {
        return $this->errcode;
    }

    public function setErrCode(?int $err_code): void
    {
        $this->errcode = $err_code;
    }

    public function fill(TransferCustomer $transferCustomer): TransferCustomer
    {
        if (Utils::notEmpty($this->getExternalUserId())) {
            $transferCustomer->external_user_id = $this->getExternalUserId();
        }
        if (Utils::notEmpty($this->getErrCode())) {
            $transferCustomer->transfer_err_code = $this->getErrCode();
        }

        return $transferCustomer;
    }
}
