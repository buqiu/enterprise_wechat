<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Customer\ExternalContactDto;
use Buqiu\EnterpriseWechat\Dto\Customer\FollowUserDto;
use Buqiu\EnterpriseWechat\Dto\Customer\RemarkDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferCustomerDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferResultDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferUserDto;
use Buqiu\EnterpriseWechat\Events\CustomerModelEvent;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Buqiu\EnterpriseWechat\Models\User;
use Exception;

class CustomerService
{
    /**
     * 同步客户列表
     *
     * @throws Exception
     */
    public static function syncList(array $contact_list, bool $trigger_event = false): void
    {
        foreach ($contact_list as $contact) {
            $customer = CustomerService::sync($contact['external_contact'], $contact['follow_info']);
            if ($trigger_event) {
                CustomerModelEvent::dispatch($customer->getKey());
            }
        }
    }

    /**
     * 同步客户详情
     *
     * @throws Exception
     */
    public static function syncGet(array $external_contact, array $follow_users): void
    {
        foreach ($follow_users as $follow_user) {
            CustomerService::sync($external_contact, $follow_user);
        }
    }

    /**
     * 同步客户
     *
     * @throws Exception
     */
    public static function sync(array $external_contact, array $follow_user, array $data = []): Customer
    {
        return SyncService::customer(new ExternalContactDto($external_contact), new FollowUserDto($follow_user), $data);
    }

    /**
     * 修改客户备注信息
     */
    public static function remark(RemarkDto $remarkDto): void
    {
        SyncService::remarkCustomer($remarkDto);
    }

    /**
     * 删除客户
     */
    public static function delete(string $user_id, string $external_user_id, ?array $data = []): void
    {
        $user = User::withCorpId()->whereAccountId($user_id)->withTrashed()->first();
        if (! $user) {
            return;
        }
        SyncService::deleteCustomer($user, $external_user_id, $data);
    }
}
