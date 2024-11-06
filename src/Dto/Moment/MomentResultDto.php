<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Moment;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Moment;
use Buqiu\EnterpriseWechat\Utils\Utils;

class MomentResultDto extends Dto
{
    public ?int $status = null;

    public ?string $moment_id = null;

    public ?array $invalid_sender_list = [];

    public ?array $invalid_external_contact_list = [];

    public ?array $result = [];

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(?array $result): void
    {
        $this->result = $result;
    }

    public function getMomentId(): ?string
    {
        return $this->moment_id;
    }

    public function setMomentId(?string $moment_id): void
    {
        $this->moment_id = $moment_id;
    }

    public function getInvalidSenderList(): ?array
    {
        return $this->invalid_sender_list;
    }

    public function setInvalidSenderList(?array $invalid_sender_list): void
    {
        $this->invalid_sender_list = $invalid_sender_list;
    }

    public function getInvalidExternalContactList(): ?array
    {
        return $this->invalid_external_contact_list;
    }

    public function setInvalidExternalContactList(?array $invalid_external_contact_list): void
    {
        $this->invalid_external_contact_list = $invalid_external_contact_list;
    }

    public function fill(Moment $moment): Moment
    {
        if (Utils::notEmpty($this->getStatus())) {
            $moment->status = $this->getStatus();
        }
        if (Utils::notEmpty($this->getMomentId())) {
            $moment->moment_id = $this->getMomentId();
        }
        if (Utils::notEmpty($this->getInvalidSenderList())) {
            $moment->invalid_sender_list = $this->getInvalidSenderList();
        }
        if (Utils::notEmpty($this->getInvalidExternalContactList())) {
            $moment->invalid_external_contact_list = $this->getInvalidExternalContactList();
        }

        return $moment;
    }
}
