<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Media;

use Buqiu\EnterpriseWechat\Dto\Dto;
use Buqiu\EnterpriseWechat\Models\Media;
use Buqiu\EnterpriseWechat\Utils\Utils;

class MediaUrlDto extends Dto
{
    public ?string $type = null;

    public ?string $name = null;

    public ?string $filename = null;

    public ?string $media_id = null;

    public ?string $created_at = null;

    public ?string $url = null;

    public ?int $scene = null;

    public ?string $md5 = null;

    public ?string $jobid = null;

    public ?int $status = null;

    public ?int $errcode = null;

    public ?string $errmsg = null;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getJobid(): ?string
    {
        return $this->jobid;
    }

    public function setJobid(?string $jobid): void
    {
        $this->jobid = $jobid;
    }

    public function getMd5(): ?string
    {
        return $this->md5;
    }

    public function setMd5(?string $md5): void
    {
        $this->md5 = $md5;
    }

    public function getScene(): ?int
    {
        return $this->scene;
    }

    public function setScene(?int $scene): void
    {
        $this->scene = $scene;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getMediaId(): ?string
    {
        return $this->media_id;
    }

    public function setMediaId(?string $media_id): void
    {
        $this->media_id = $media_id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getErrmsg(): ?string
    {
        return $this->errmsg;
    }

    public function setErrmsg(?string $errmsg): void
    {
        $this->errmsg = $errmsg;
    }

    public function getErrcode(): ?int
    {
        return $this->errcode;
    }

    public function setErrcode(?int $errcode): void
    {
        $this->errcode = $errcode;
    }

    public function fill(Media $media): Media
    {
        if (Utils::notEmpty($this->getScene())) {
            $media->scene = $this->getScene();
        }
        if (Utils::notEmpty($this->getMd5())) {
            $media->file_md5 = $this->getMd5();
        }
        if (Utils::notEmpty($this->getJobid())) {
            $media->job_id = $this->getJobid();
        }
        if (Utils::notEmpty($this->getStatus())) {
            $media->upload_status = $this->getStatus();
        }
        if (Utils::notEmpty($this->getType())) {
            $media->type = $this->getType();
        }
        if (Utils::notEmpty($this->getFileName())) {
            $media->file_name = $this->getFileName();
        }
        if (Utils::notEmpty($this->getMediaId())) {
            $media->media_id = $this->getMediaId();
        }
        if (Utils::notEmpty($this->getUrl())) {
            $media->url = $this->getUrl();
        }
        if (Utils::notEmpty($this->getCreatedAt())) {
            $media->media_created_at = $this->getCreatedAt();
        }
        if (! empty($this->getErrcode())) {
            $media->err_msg = $this->getErrcode().'-'.$this->getErrmsg();
        }

        return $media;
    }
}
