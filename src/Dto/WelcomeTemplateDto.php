<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\WelcomeTemplate;
use Buqiu\EnterpriseWechat\Utils\Utils;

class WelcomeTemplateDto extends Dto
{
    public ?string $template_id = null;

    public ?array $text = [];

    public ?array $image = [];

    public ?array $link = [];

    public ?array $miniprogram = [];

    public ?array $file = [];

    public ?array $video = [];

    public ?int $notify = null;

    public ?int $agentid = null;

    public function getText(): ?array
    {
        return $this->text;
    }

    public function setText(?array $text): void
    {
        $this->text = $text;
    }

    public function getImage(): ?array
    {
        return $this->image;
    }

    public function setImage(?array $image): void
    {
        $this->image = $image;
    }

    public function getLink(): ?array
    {
        return $this->link;
    }

    public function setLink(?array $link): void
    {
        $this->link = $link;
    }

    public function getMiniProgram(): ?array
    {
        return $this->miniprogram;
    }

    public function setMiniProgram(?array $mini_program): void
    {
        $this->miniprogram = $mini_program;
    }

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function setFile(?array $file): void
    {
        $this->file = $file;
    }

    public function getVideo(): ?array
    {
        return $this->video;
    }

    public function setVideo(?array $video): void
    {
        $this->video = $video;
    }

    public function getNotify(): ?int
    {
        return $this->notify;
    }

    public function setNotify(?int $notify): void
    {
        $this->notify = $notify;
    }

    public function getTemplateId(): ?string
    {
        return $this->template_id;
    }

    public function setTemplateId(?string $template_id): void
    {
        $this->template_id = $template_id;
    }

    public function getAgentId(): ?int
    {
        return $this->agentid;
    }

    public function setAgentId(?int $agent_id): void
    {
        $this->agentid = $agent_id;
    }

    public function fill(WelcomeTemplate $welcomeTemplate): WelcomeTemplate
    {
        if (Utils::notEmpty($this->getTemplateId())) {
            $welcomeTemplate->template_id = $this->getTemplateId();
        }
        if (Utils::notEmpty($this->getText())) {
            $welcomeTemplate->text = $this->getText();
        }
        if (Utils::notEmpty($this->getImage())) {
            $welcomeTemplate->image = $this->getImage();
        }
        if (Utils::notEmpty($this->getLink())) {
            $welcomeTemplate->link = $this->getLink();
        }
        if (Utils::notEmpty($this->getMiniProgram())) {
            $welcomeTemplate->mini_program = $this->getMiniProgram();
        }
        if (Utils::notEmpty($this->getFile())) {
            $welcomeTemplate->file = $this->getFile();
        }
        if (Utils::notEmpty($this->getVideo())) {
            $welcomeTemplate->video = $this->getVideo();
        }
        if (Utils::notEmpty($this->getNotify())) {
            $welcomeTemplate->notify = $this->getNotify();
        }

        return $welcomeTemplate;
    }
}
