<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Dto\Customer\RemarkDto;
use Buqiu\EnterpriseWechat\Models\User as UserModel;
use Buqiu\EnterpriseWechat\Services\CustomerService;
use Buqiu\EnterpriseWechat\Services\TransferCustomerService;
use Exception;

class Customer extends Lib
{
    /**
     * 同步成员客户列表
     *
     * @throws Exception
     */
    public function syncList(): void
    {
        $users = UserModel::withCorpId()->get('account_id');
        foreach ($users->chunk(100) as $chunk) {
            $this->syncOne($chunk->pluck('account_id')->flatten()->toArray());
        }
    }

    /**
     * 同步单个客户列表
     *
     * @throws Exception
     */
    public function syncOne(array $account_ids): void
    {
        $cursor = null;
        do {
            [$cursor, $contact_list] = $this->api->batchGetByUser($account_ids, $cursor);
            CustomerService::syncList($contact_list, true);
        } while ($cursor);
    }

    /**
     * 同步单个客户成员详情
     *
     * @throws Exception
     */
    public function syncGet(string $external_user_id): void
    {
        $cursor = null;
        do {
            [$cursor, $external_contact, $follow_users] = $this->api->get($external_user_id, $cursor);
            CustomerService::syncGet($external_contact, $follow_users);
        } while ($cursor);
    }

    /**
     * 同步单个客户成员
     *
     * @throws Exception
     */
    public function syncUserIdGet(string $external_user_id, string $user_id, array $data = []): void
    {
        $cursor = null;
        do {
            [$cursor, $external_contact, $follow_users] = $this->api->get($external_user_id, $cursor);

            $follow_user = collect($follow_users)->firstWhere('userid', $user_id);
            if ($follow_user) {
                CustomerService::sync($external_contact, $follow_user, $data);
                break;
            }
        } while ($cursor);
    }

    /**
     * 删除客户
     */
    public function delete(string $user_id, string $external_user_id, array $data): void
    {
        CustomerService::delete($user_id, $external_user_id, $data);
    }

    /**
     * 修改客户备注信息
     *
     * @throws Exception
     */
    public function remark(array $data): void
    {
        $remarkDto = new RemarkDto($data);
        $this->api->remark($remarkDto->getParams());
        CustomerService::remark($remarkDto);
    }

    /**
     * 分配在职成员的客户
     *
     * @throws Exception
     */
    public function transferCustomer(array $data): array
    {
        $result = $this->api->transferCustomer($data);

        TransferCustomerService::transferCustomer($data, $result);

        return $result;
    }

    /**
     * 分配离职成员的客户
     *
     * @throws Exception
     */
    public function resignedTransferCustomer(array $data): array
    {
        $result = $this->api->resignedTransferCustomer($data);

        TransferCustomerService::transferCustomer($data, $this->api->resignedTransferCustomer($data));

        return $result;
    }

    /**
     * 同步查询在职客户接替状态
     *
     * @throws Exception
     */
    public function transferResult(string $handover_user_id, string $takeover_user_id): array
    {
        $cursor = null;
        $result = [];
        do {
            [$cursor, $customers] = $this->api->transferResult($handover_user_id, $takeover_user_id, $cursor);
            $result               = array_merge($result, $customers);
            TransferCustomerService::transferResult($handover_user_id, $takeover_user_id, $customers);
        } while ($cursor);

        return $result;
    }

    /**
     * 同步查询在职客户接替状态(分页)
     *
     * @throws Exception
     */
    public function transferResultPage(string $handover_user_id, string $takeover_user_id, ?string $cursor = null): array
    {
        [$cursor, $customers] = $this->api->transferResult($handover_user_id, $takeover_user_id, $cursor);

        TransferCustomerService::transferResult($handover_user_id, $takeover_user_id, $customers);

        return [$cursor, $customers];
    }

    /**
     * 同步查询离职客户接替状态
     *
     * @throws Exception
     */
    public function resignedTransferResult(string $handover_user_id, string $takeover_user_id): array
    {
        $cursor = null;
        $result = [];
        do {
            [$cursor, $customers] = $this->api->resignedTransferResult($handover_user_id, $takeover_user_id, $cursor);
            $result               = array_merge($result, $customers);
            TransferCustomerService::transferResult($handover_user_id, $takeover_user_id, $customers);
        } while ($cursor);

        return $result;
    }

    /**
     * 同步查询离职客户接替状态(分页)
     *
     * @throws Exception
     */
    public function resignedTransferResultPage(string $handover_user_id, string $takeover_user_id, ?string $cursor = null): array
    {
        [$cursor, $customers] = $this->api->resignedTransferResult($handover_user_id, $takeover_user_id, $cursor);
        TransferCustomerService::transferResult($handover_user_id, $takeover_user_id, $customers);

        return [$cursor, $customers];
    }
}
