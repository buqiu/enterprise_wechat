<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Services\UserService;
use Exception;

/**
 * 通讯录管理-成员管理
 */
class User extends Lib
{
    /**
     * 同步部门成员详情
     *
     * @throws Exception
     */
    public function syncList(bool $trigger_event = true): void
    {
        foreach (Department::withCorpId()->get() as $department) {
            UserService::syncList($this->api->list($department->department_id), $trigger_event);
        }
    }

    /**
     * 同步部门成员详情
     *
     * @throws Exception
     */
    public function syncResignList(bool $trigger_event = true): void
    {
        foreach (Department::withCorpId()->get() as $department) {
            $users    = UserService::getByDepartment($department->id);
            $userData = $this->api->list($department->department_id);
            foreach ($users as $user) {
                UserService::syncResignList($user, $userData, $trigger_event);
            }
        }
    }

    /**
     * 同步部门成员详情
     *
     * @throws Exception
     */
    public function syncDepartmentUser(int $department_id): void
    {
        UserService::syncList($this->api->list($department_id));
    }

    /**
     * 同步成员详情
     *
     * @throws Exception
     */
    public function syncGet(string $user_id): void
    {
        UserService::syncGet($this->api->get($user_id));
    }

    /**
     * 创建成员
     *
     * @throws Exception
     */
    public function create(array $data): void
    {
        $userDto = UserService::checkCreateParams($data);

        $this->api->create($userDto->getData());

        UserService::create($userDto);
    }

    /**
     * 更新成员
     *
     * @throws Exception
     */
    public function update(string $user_id, array $data): void
    {
        $userDto = UserService::checkUpdateParams(array_merge($data, ['userid' => $user_id]));

        $this->api->update($userDto->getData());

        UserService::update($userDto);
    }

    /**
     * 删除成员
     *
     * @throws Exception
     */
    public function delete(string $user_id): string
    {
        $this->api->delete($user_id);

        UserService::delete($user_id);

        return $user_id;
    }

    /**
     * 批量删除成员
     *
     * @throws Exception
     */
    public function batchDelete(array $user_id_list): array
    {
        $this->api->batchDelete($user_id_list);

        UserService::delete($user_id_list);

        return $user_id_list;
    }

    /**
     * 同步配置客户联系功能的成员列表
     */
    public function syncFollowUserList(): void
    {
        UserService::syncFollowUserList($this->api->getFollowUserList());
    }
}
