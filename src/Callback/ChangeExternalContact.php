<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback;

use Buqiu\EnterpriseWechat\Contracts\CallBackAbstract;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferResultDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Services\TransferCustomerService;
use Exception;

class ChangeExternalContact extends CallBackAbstract
{
    /**
     * 添加企业客户
     *
     * @throws Exception
     */
    public function addExternalContact(): void
    {
        EnterpriseWechatFacade::customer()->syncUserIdGet($this->data['external_user_id'], (string) $this->data['user_id'], [
            'welcome_code' => $this->data['welcome_code'],
            'state'        => $this->data['state'],
        ]);
    }

    /**
     * 编辑企业客户
     *
     * @throws Exception
     */
    public function editExternalContact(): void
    {
        EnterpriseWechatFacade::customer()->syncUserIdGet($this->data['external_user_id'], (string) $this->data['user_id']);
    }

    /**
     * 外部联系人免验证添加成员(未建立关联不处理)
     *
     * @throws Exception
     */
    public function addHalfExternalContact(): void {}

    /**
     * 删除企业客户
     *
     * @throws Exception
     */
    public function delExternalContact(): void
    {
        EnterpriseWechatFacade::customer()->delete((string) $this->data['user_id'], $this->data['external_user_id'], $this->data);
    }

    /**
     * 删除跟进成员
     *
     * @throws Exception
     */
    public function delFollowUser(): void
    {
        EnterpriseWechatFacade::customer()->delete((string) $this->data['user_id'], $this->data['external_user_id'], $this->data);
    }

    /**
     * 客户接替失败
     *
     * @throws Exception
     */
    public function transferFail(): array
    {
        TransferCustomerService::syncTransferFail(new TransferResultDto([
            'takeover_userid'  => (string) $this->data['account_id'],
            'external_user_id' => $this->data['external_user_id'],
            'status'           => $this->data['errcode'],
            'takeover_time'    => time(),
        ]));

        return $this->data;
    }
}
