<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Utils\LogHelper;

class DepartmentEvent extends Event
{
    public function getDepartmentId()
    {
        return $this->data['id'];
    }

    public function bind(): mixed
    {
        $department = Department::withCorpId()->whereDepartmentId($this->getDepartmentId())->withTrashed()->firstOrFail();

        LogHelper::event(static::class, $department->toArray());

        return $department;
    }
}
