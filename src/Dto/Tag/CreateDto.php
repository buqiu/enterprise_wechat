<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Tag;

use Buqiu\EnterpriseWechat\Dto\TagDto;

/**
 * 新建标签属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90210
 */
class CreateDto extends TagDto
{
    protected array $valid_require_property = [
        'tagname',
    ];
}
