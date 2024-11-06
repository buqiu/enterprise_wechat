<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\Media;
use Buqiu\EnterpriseWechat\Utils\Utils;

class MediaDto extends Dto
{
    public ?string $type = null;

    public ?string $name = null;

    public ?string $filename = null;

    public mixed $contents = '';

    public ?string $media_id = null;

    public ?string $created_at = null;

    public ?string $url = null;

    protected array $valid_require_property = [
        'contents', 'filename',
    ];

    public function getFileName(): ?string
    {
        return $this->filename;
    }

    public function setFileName(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getContents(): mixed
    {
        return $this->contents;
    }

    public function setContents(mixed $contents): void
    {
        $this->contents = $contents;
    }

    public function getMediaId(): ?string
    {
        return $this->media_id;
    }

    public function setMediaId(?string $media_id): void
    {
        $this->media_id = $media_id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function fill(Media $media): Media
    {
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

        return $media;
    }
}
