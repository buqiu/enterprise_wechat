<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Transfer;

use Buqiu\EnterpriseWechat\Utils\Utils;

class TransferResult
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
     * 分页游标.
     */
    public ?string $cursor = null;

    /**
     * 客户信息.
     */
    public array $customers = [];

    /**
     * @note 校验参数
     * @author eva
     *
     * @param  TransferResult $transferResult
     * @throws \Exception
     */
    public static function checkArgs(TransferResult $transferResult)
    {
        Utils::checkNotEmptyStr($transferResult->handoverUserId, 'handover_userid');

        Utils::checkNotEmptyStr($transferResult->takeoverUserId, 'takeover_userid');
    }

    /**
     * @note 处理参数
     * @author eva
     *
     * @param  TransferResult $transferResult
     * @return array
     */
    public static function handleArgs(TransferResult $transferResult): array
    {
        $args = [];

        Utils::setIfNotNull($transferResult->handoverUserId, 'handover_userid', $args);
        Utils::setIfNotNull($transferResult->takeoverUserId, 'takeover_userid', $args);
        Utils::setIfNotNull($transferResult->cursor, 'cursor', $args);

        return $args;
    }

    /**
     * @note 处理响应
     * @author eva
     *
     * @param  array          $rsp
     * @return TransferResult
     */
    public static function handleRsp(array $rsp): TransferResult
    {
        $e = new TransferResult();

        if (Utils::notEmptyStr($rsp['next_cursor'] ?? '')) {
            $e->cursor = $rsp['next_cursor'];
        }

        if (array_key_exists('customer', $rsp) && Utils::notEmptyArr($rsp['customer'])) {
            foreach ($rsp['customer'] as $item) {
                $e->customers[$item['external_userid']] = [
                    'status'        => $item['status']        ?? null,
                    'takeover_time' => $item['takeover_time'] ?? null,
                ];
            }
        }

        return $e;
    }
}
