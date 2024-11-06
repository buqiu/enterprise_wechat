<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Models\Department as DepartmentModel;
use Buqiu\EnterpriseWechat\Services\DepartmentService;
use Exception;

/**
 * 通讯录管理-部门管理
 */
class Department extends Lib
{
    /**
     * 同步部门数据
     *
     * @throws Exception
     */
    public function syncList(bool $trigger_event = true): void
    {
        DepartmentService::syncList($this->api->list(), $trigger_event);
    }

    /**
     * 同步单部门数据
     *
     * @throws Exception
     */
    public function syncGet(int $department_id): void
    {
        DepartmentService::syncGet($this->api->get($department_id));
    }

    /**
     * 创建部门
     *
     * @throws Exception
     */
    public function create(array $data): void
    {
        $departmentDto = DepartmentService::checkCreateParams($data);

        DepartmentService::create($departmentDto, $this->api->create($departmentDto->getData()));
    }

    /**
     * 更新部门
     *
     * @throws Exception
     */
    public function update(int $id, array $data = []): void
    {
        $departmentDto = DepartmentService::checkUpdateParams(array_merge($data, compact('id')));

        $this->api->update($departmentDto->getData());

        DepartmentService::update($departmentDto);
    }

    /**
     * 删除部门
     */
    public function delete(int $department_id): void
    {
        $this->api->delete($department_id);

        DepartmentService::delete($department_id);
    }
}
