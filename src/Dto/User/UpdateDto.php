<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\User;

use Buqiu\EnterpriseWechat\Dto\UserDto;

/**
 * 修改成员属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90197
 */
class UpdateDto extends UserDto
{
    protected array $valid_require_property = [
        'userid',
    ];
}
