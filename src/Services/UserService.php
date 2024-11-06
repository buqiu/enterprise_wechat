<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\User\CreateDto;
use Buqiu\EnterpriseWechat\Dto\User\UpdateDto;
use Buqiu\EnterpriseWechat\Dto\UserDto;
use Buqiu\EnterpriseWechat\Enums\User\UserStatusEnum;
use Buqiu\EnterpriseWechat\Events\UserModelEvent;
use Buqiu\EnterpriseWechat\Events\UserResignModelEvent;
use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;

class UserService
{
    /**
     * 同步部门成员数据
     *
     * @throws Exception
     */
    public static function syncList(array $user_lists, bool $trigger_event = false): void
    {
        foreach ($user_lists as $user_list) {
            $user = SyncService::user(new UserDto($user_list));
            if ($trigger_event) {
                UserModelEvent::dispatch($user->getKey());
            }
        }
    }

    /**
     * 同步部门离职成员数据
     *
     * @throws Exception
     */
    public static function syncResignList(User $user, array $user_lists, bool $trigger_event = false): void
    {
        $exist = false;
        foreach ($user_lists as $user_list) {
            $userDto = new UserDto($user_list);
            if ($user->account_id == $userDto->getUserId()) {
                $exist = true;
                break;
            }
        }
        if ($exist) {
            return;
        }

        $user->status = UserStatusEnum::STATUS_RESIGN->value;
        $user->save();

        if ($trigger_event) {
            UserResignModelEvent::dispatch($user->getKey());
        }
    }

    /**
     * 同步部门成员数据
     *
     * @throws Exception
     */
    public static function syncGet(array $data): void
    {
        SyncService::user(new UserDto($data));
    }

    /*
     * 删除部门成员
     */
    public static function deleteDepartmentUser(string $department_id): void
    {
        SyncService::deleteDepartmentUser($department_id);
    }

    /*
    * 离职部门成员
    */
    public static function resignDepartmentUser(string $department_id): void
    {
        SyncService::resignDepartmentUser($department_id);
    }

    /**
     * 获取默认部门ID
     */
    public static function getDefaultDepartmentId()
    {
        $defaultDepartment = Department::withCorpId()->whereName('其他（待设置部门）')->first();

        return object_get($defaultDepartment, 'department_id');
    }

    /**
     * 删除成员
     */
    public static function delete(array|string $user_id_list): void
    {
        SyncService::deleteUser($user_id_list);
    }

    /**
     * 获取成员
     */
    public static function getByDepartment(string $department_id)
    {
        return User::withCorpId()->whereDepartmentId($department_id)->get();
    }

    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(array $data): UserDto
    {
        $userDto = new CreateDto($data);
        if (Utils::empty($userDto->getDepartment())) {
            $userDto->setDepartment([UserService::getDefaultDepartmentId()]);
        }

        return $userDto;
    }

    /**
     * 检测入参(更新)
     *
     * @throws Exception
     */
    public static function checkUpdateParams(array $data): UserDto
    {
        return new UpdateDto($data);
    }

    /**
     * 创建成员
     */
    public static function create(UserDto $userDto): void
    {
        SyncService::user($userDto);
    }

    /**
     * 更新成员
     */
    public static function update(UserDto $userDto): void
    {
        SyncService::user($userDto);
    }

    /**
     * 同步配置客户联系功能的成员列表
     */
    public static function syncFollowUserList(array $follow_users): void
    {
        SyncService::enableCustomerUser($follow_users);
    }

    /**
     * 更换账号
     */
    public static function syncNewUser(string $user_id, ?string $new_user_id = null): string
    {
        if (Utils::empty($new_user_id)) {
            return $user_id;
        }

        if ($user_id == $new_user_id) {
            return $user_id;
        }
        User::withCorpId()->whereAccountId($user_id)->update(['account_id' => $new_user_id]);

        return $new_user_id;
    }
}
