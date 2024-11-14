<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Customer extends Api
{
    /**
     * 获取客户列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/92113
     * @throws GuzzleException
     */
    public function list(string $userid): array
    {
        $result = $this->httpGet('cgi-bin/externalcontact/list', $this->mergeTokenData(compact('userid')));

        return $result['external_userid'];
    }

    /**
     * 获取客户详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/92114
     * @throws GuzzleException
     */
    public function get(string $external_userid, ?string $cursor = null): array
    {
        $result = $this->httpGet('cgi-bin/externalcontact/get', $this->mergeTokenData(compact('external_userid', 'cursor')));

        return [$result['next_cursor'] ?? null, $result['external_contact'], $result['follow_user']];
    }

    /**
     * 批量获取客户详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/92994
     * @throws GuzzleException
     */
    public function batchGetByUser(array $userid_list, ?string $cursor = null, ?int $limit = 100): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/batch/get_by_user', compact(['userid_list', 'cursor', 'limit']), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['external_contact_list']];
    }

    /**
     * 修改客户备注信息
     *
     * @link https://developer.work.weixin.qq.com/document/path/92115
     * @throws GuzzleException
     */
    public function remark(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/remark', $data, $this->mergeTokenData());
    }

    /**
     * 分配在职成员的客户
     *
     * @link https://developer.work.weixin.qq.com/document/path/92125
     * @throws GuzzleException
     */
    public function transferCustomer(array $data): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/transfer_customer', $data, $this->mergeTokenData());

        return $result['customer'];
    }

    /**
     * 查询客户接替状态
     *
     * @link https://developer.work.weixin.qq.com/document/path/94088
     * @throws GuzzleException
     */
    public function transferResult(string $handover_userid, string $takeover_userid, mixed $cursor = null): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/transfer_result', compact('handover_userid', 'takeover_userid', 'cursor'), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['customer']];
    }

    /**
     * 分配离职成员的客户
     *
     * @link https://developer.work.weixin.qq.com/document/path/94081
     * @throws GuzzleException
     */
    public function resignedTransferCustomer(array $data): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/resigned/transfer_customer', $data, $this->mergeTokenData());

        return $result['customer'];
    }

    /**
     * 查询客户接替状态
     *
     * @link https://developer.work.weixin.qq.com/document/path/94082
     * @throws GuzzleException
     */
    public function resignedTransferResult(string $handover_userid, string $takeover_userid, mixed $cursor = null): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/resigned/transfer_result', compact('handover_userid', 'takeover_userid', 'cursor'), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['customer']];
    }

    /**
     * 查询客户接替状态
     *
     * @link https://developer.work.weixin.qq.com/document/path/94082
     * @throws GuzzleException
     */
    public function getUnassignedList(mixed $cursor = null, int $page_size = 1000): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/resigned/get_unassigned_list', compact('cursor', 'page_size'), $this->mergeTokenData());
    }
}
