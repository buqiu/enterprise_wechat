<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\User;

use Buqiu\EnterpriseWechat\Dto\UserDto;

/**
 * 新建成员属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90195
 */
class CreateDto extends UserDto
{
    protected array $valid_require_property = [
        'userid', 'name',
    ];
}
