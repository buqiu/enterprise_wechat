<?php

namespace Buqiu\EnterpriseWechat\Events\ChangeContact;

use Buqiu\EnterpriseWechat\Events\UserEvent;
use Buqiu\EnterpriseWechat\Models\User;

/**
 * 更新成员事件
 */
class UpdateUserEvent extends UserEvent
{
    public function getAccountId()
    {
        return $this->data['new_user_id'];
    }
}
