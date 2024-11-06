<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback;

use Buqiu\EnterpriseWechat\Contracts\CallBackAbstract;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Services\DepartmentService;
use Buqiu\EnterpriseWechat\Services\UserService;
use Buqiu\EnterpriseWechat\Services\UserTagService;
use Exception;

class ChangeContact extends CallBackAbstract
{
    /**
     * 创建部门
     *
     * @throws Exception
     */
    public function createParty(): void
    {
        EnterpriseWechatFacade::department()->syncGet($this->data['id']);
    }

    /**
     * 更新部门
     *
     * @throws Exception
     */
    public function updateParty(): void
    {
        EnterpriseWechatFacade::department()->syncGet($this->data['id']);
    }

    /**
     * 删除部门
     */
    public function deleteParty(): void
    {
        DepartmentService::delete($this->data['id']);
    }

    /**
     * 变更标签
     */
    public function updateTag(): void
    {
        UserTagService::addList($this->data['tag_id'], $this->data['add_user_list'], $this->data['add_party_list']);
        UserTagService::delList($this->data['tag_id'], $this->data['del_user_list'], $this->data['del_party_list']);
    }

    /**
     * 新增成员
     *
     * @throws Exception
     */
    public function createUser(): void
    {
        EnterpriseWechatFacade::user()->syncGet($this->data['user_id']);
    }

    /**
     * 更新成员
     *
     * @throws Exception
     */
    public function updateUser(): void
    {
        $this->data['new_user_id'] = UserService::syncNewUser($this->data['user_id'], $this->data['new_user_id']);

        EnterpriseWechatFacade::user()->syncGet($this->data['new_user_id']);
    }

    /**
     * 删除成员
     */
    public function deleteUser(): void
    {
        UserService::delete($this->data['user_id']);
    }
}
