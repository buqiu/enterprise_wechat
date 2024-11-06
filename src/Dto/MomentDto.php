<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\GroupChat;
use Buqiu\EnterpriseWechat\Models\Moment;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;

class MomentDto extends Dto
{
    public ?string $job_id = null;

    public ?array $text = [];

    public ?array $attachments = [];

    public ?array $visible_range = [];

    public function getText(): ?array
    {
        return $this->text;
    }

    public function setText(?array $text): void
    {
        $this->text = $text;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function setAttachments(?array $attachments): void
    {
        $this->attachments = $attachments;
    }

    public function getVisibleRange(): ?array
    {
        return $this->visible_range;
    }

    public function setVisibleRange(?array $visible_range): void
    {
        $this->visible_range = $visible_range;
    }

    public function getJobId(): ?string
    {
        return $this->job_id;
    }

    public function setJobId(?string $job_id): void
    {
        $this->job_id = $job_id;
    }

    public function fill(Moment $moment): Moment
    {
        if (Utils::notEmpty($this->getJobId())) {
            $moment->job_id = $this->getJobId();
        }
        if (Utils::notEmpty($this->getText())) {
            $moment->text = $this->getText();
        }
        if (Utils::notEmpty($this->getAttachments())) {
            $moment->attachments = $this->getAttachments();
        }
        if (Utils::notEmpty($this->getVisibleRange())) {
            $moment->visible_range = $this->getVisibleRange();
        }

        return $moment;
    }
}
