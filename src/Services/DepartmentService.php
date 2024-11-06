<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Department\CreateDto;
use Buqiu\EnterpriseWechat\Dto\Department\UpdateDto;
use Buqiu\EnterpriseWechat\Dto\DepartmentDto;
use Buqiu\EnterpriseWechat\Events\DepartmentModelEvent;
use Buqiu\EnterpriseWechat\Models\Department;
use Exception;

class DepartmentService
{
    /**
     * 同步部门数据
     *
     * @throws Exception
     */
    public static function syncList(array $data, bool $trigger_event = false): void
    {
        $department_ids = [];
        foreach ($data as $datum) {
            $department       = SyncService::department(new DepartmentDto($datum));
            $department_ids[] = $department->department_id;
        }

        $softDepartments = Department::withCorpId()->whereNotIn('department_id', $department_ids)->get();
        foreach ($softDepartments as $softDepartment) {
            $softDepartment->delete();
            if ($trigger_event) {
                DepartmentModelEvent::dispatch($softDepartment->getKey());
            }
        }

        $department = Department::withCorpId()->whereDepartmentId(1)->firstOrFail();
        SyncService::departmentCallPath($department);
        if (! $trigger_event) {
            return;
        }

        $departments = Department::withCorpId()->get();
        foreach ($departments as $department) {
            DepartmentModelEvent::dispatch($department->getKey());
        }
    }

    /**
     * 同步单个部门数据
     *
     * @throws Exception
     */
    public static function syncGet($data): void
    {
        $department = SyncService::department(new DepartmentDto($data));
        SyncService::departmentCallPath($department);
    }

    /**
     * 解析 PATH
     */
    public static function parseModelPath(DepartmentDto $departmentDto): array
    {
        $parentDepartment = Department::withCorpId()->whereDepartmentId($departmentDto->getParentId())->first();

        return $parentDepartment ? array_merge($parentDepartment->path, [$departmentDto->getId()]) : [$departmentDto->getId()];
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): DepartmentDto
    {
        return new CreateDto($data);
    }

    /**
     * 检测入参(更新)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): DepartmentDto
    {
        return new UpdateDto($data);
    }

    /**
     * 删除部门数据
     */
    public static function delete(int $department_id): void
    {
        SyncService::deleteDepartment($department_id);
    }

    /**
     * 新建部门数据
     */
    public static function create(DepartmentDto $departmentDto, int $department_id): void
    {
        $departmentDto->setId($department_id);
        $departmentDto->setPath(DepartmentService::parseModelPath($departmentDto));
        SyncService::department($departmentDto);
    }

    /**
     * 更新部门数据
     */
    public static function update(DepartmentDto $departmentDto): void
    {
        SyncService::departmentCallPath(SyncService::department($departmentDto));
    }
}
