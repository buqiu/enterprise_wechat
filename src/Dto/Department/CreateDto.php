<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\Department;

use Buqiu\EnterpriseWechat\Dto\DepartmentDto;

/**
 * 新建部门属性入参
 *
 * @link https://developer.work.weixin.qq.com/document/path/90205
 */
class CreateDto extends DepartmentDto
{
    protected array $valid_require_property = [
        'name', 'parentid',
    ];

    protected array $exclude_property = [
        'department_leader',
    ];
}
