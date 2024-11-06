<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Department;

use Buqiu\EnterpriseWechat\Dto\DepartmentDto;

/**
 * 修改部门属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90206
 */
class UpdateDto extends DepartmentDto
{
    protected array $valid_require_property = [
        'id',
    ];

    protected array $exclude_property = [
        'department_leader',
    ];
}
