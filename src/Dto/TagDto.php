<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Models\Tag;
use Buqiu\EnterpriseWechat\Utils\Utils;

/**
 * 标签属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90216
 */
class TagDto extends Dto
{
    public ?string $tagname = null;

    public ?int $tagid = null;

    public function getTagName(): ?string
    {
        return $this->tagname;
    }

    public function setTagName(?string $tag_name): void
    {
        $this->tagname = $tag_name;
    }

    public function getTagId(): ?int
    {
        return $this->tagid;
    }

    public function setTagId(?int $tag_id): void
    {
        $this->tagid = $tag_id;
    }

    public function fill(Tag $tag): Tag
    {
        if (Utils::notEmpty($this->getTagId())) {
            $tag->tag_id = $this->getTagId();
        }
        if (Utils::notEmpty($this->getTagName())) {
            $tag->tag_name = $this->getTagName();
        }

        return $tag;
    }
}
