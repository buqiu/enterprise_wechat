<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class ContactWay extends Api
{
    /**
     * 配置客户联系「联系我」方式
     *
     * @link https://developer.work.weixin.qq.com/document/path/92228
     * @throws GuzzleException
     */
    public function create(array $data): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/add_contact_way', $data, $this->mergeTokenData());

        return ['config_id' => $result['config_id'], 'qr_code' => $result['qr_code']];
    }

    /**
     * 获取企业已配置的「联系我」方式
     *
     * @link https://developer.work.weixin.qq.com/document/path/92228
     * @throws GuzzleException
     */
    public function show(string $config_id): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/get_contact_way', compact(['config_id']), $this->mergeTokenData());

        return $result['contact_way'];
    }

    /**
     * 获取企业已配置的「联系我」列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/92228
     * @throws GuzzleException
     */
    public function list(?int $start_time = null, ?int $end_time = null, ?string $cursor = null, ?int $limit = 100): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/list_contact_way', compact(['start_time', 'end_time', 'cursor', 'limit']), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['contact_way']];
    }

    /**
     * 更新企业已配置的「联系我」方式
     * @link https://developer.work.weixin.qq.com/document/path/92228
     * @throws GuzzleException
     * */
    public function update(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/update_contact_way', $data, $this->mergeTokenData());
    }

    /**
     * 删除企业已配置的「联系我」方式
     * @link https://developer.work.weixin.qq.com/document/path/92228
     * @throws GuzzleException
     * */
    public function delete(string $config_id): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/del_contact_way', compact('config_id'), $this->mergeTokenData());
    }
}
