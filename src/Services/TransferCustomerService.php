<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferCustomerDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferResultDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferUserDto;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Exception;

class TransferCustomerService
{
    /**
     * 分配成员的客户
     *
     * @throws Exception
     */
    public static function transferCustomer(array $data, array $external_user_list): void
    {
        $transferUserDto = new TransferUserDto($data);
        foreach ($external_user_list as $external_user) {
            SyncService::transferCustomer($transferUserDto, new TransferCustomerDto($external_user));
        }
    }

    /**
     * 基于接替人和被接替人同步客户接替状态
     *
     * @throws Exception
     */
    public static function transferResult(string $handover_user_id, string $takeover_user_id, array $customers): void
    {
        foreach ($customers as $customer) {
            SyncService::transferCustomerResult(new TransferResultDto(array_merge($customer, [
                'handover_userid' => $handover_user_id,
                'takeover_userid' => $takeover_user_id,
            ])));
        }
    }

    /**
     * 同步回调客户接替失败状态
     */
    public static function syncTransferFail(TransferResultDto $transferResultDto): void
    {
        SyncService::transferCustomerFail($transferResultDto);
    }
}
