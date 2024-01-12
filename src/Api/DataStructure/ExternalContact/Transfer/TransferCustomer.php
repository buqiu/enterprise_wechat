<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Transfer;

use Buqiu\EnterpriseWechat\Utils\Utils;

class TransferCustomer
{
    /**
     * 原跟进成员的 userid.
     */
    public ?string $handoverUserId = null;

    /**
     * 接替成员的 userid.
     */
    public ?string $takeoverUserId = null;

    /**
     * 客户的 external_userid.
     */
    public ?array $externalUserId = null;

    /**
     * 转移成功后发给客户的消息，最多200个字符，不填则使用默认文案.
     */
    public ?string $transferSuccessMsg = null;

    /**
     * 客户信息.
     */
    public array $customers = [];

    /**
     * @note 校验参数
     * @author eva
     *
     * @param  TransferCustomer $transferCustomer
     * @throws \Exception
     */
    public static function checkArgs(TransferCustomer $transferCustomer): void
    {
        Utils::checkNotEmptyStr($transferCustomer->handoverUserId, 'handover_userid');

        Utils::checkNotEmptyStr($transferCustomer->takeoverUserId, 'takeover_userid');

        Utils::checkNotEmptyArray($transferCustomer->externalUserId, 'external_userid');
    }

    /**
     * @note 处理参数
     * @author eva
     *
     * @param  TransferCustomer $transferCustomer
     * @return array
     */
    public static function handleArgs(TransferCustomer $transferCustomer): array
    {
        $args = [];

        Utils::setIfNotNull($transferCustomer->handoverUserId, 'handover_userid', $args);
        Utils::setIfNotNull($transferCustomer->takeoverUserId, 'takeover_userid', $args);
        Utils::setIfNotNull($transferCustomer->externalUserId, 'external_userid', $args);
        Utils::setIfNotNull($transferCustomer->transferSuccessMsg, 'transfer_success_msg', $args);

        return $args;
    }

    /**
     * @note 处理响应
     * @author eva
     *
     * @param  array            $rsp
     * @return TransferCustomer
     */
    public static function handleRsp(array $rsp): TransferCustomer
    {
        $e = new TransferCustomer();
        if (array_key_exists('customer', $rsp) && Utils::notEmptyArr($rsp['customer'])) {
            foreach ($rsp['customer'] as $item) {
                $e->customers[$item['external_userid']] = $item['errcode'];
            }
        }

        return $e;
    }
}
