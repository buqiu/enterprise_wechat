<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Strategy extends Api
{
    /**
     * 获取规则组列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function list(?string $cursor = null, int $limit = 1000): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/list', compact('cursor', 'limit'), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['strategy']];
    }

    /**
     * 获取规则组详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function get(int $strategy_id): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/get', compact('strategy_id'), $this->mergeTokenData());

        return $result['strategy'];
    }

    /**
     * 获取规则组管理范围
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function getRange(int $strategy_id, ?string $cursor = null, int $limit = 1000): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/get_range', compact('strategy_id', 'cursor', 'limit'), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['range']];
    }

    /**
     * 创建新的规则组
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function create(array $data): int
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/create', $data, $this->mergeTokenData());

        return $result['strategy_id'];
    }

    /**
     * 编辑规则组及其管理范围
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function edit(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/edit', $data, $this->mergeTokenData());
    }

    /**
     * 删除规则组
     *
     * @link https://developer.work.weixin.qq.com/document/path/94883
     *
     * @throws GuzzleException
     */
    public function delete(int $strategy_id): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/customer_strategy/del', compact('strategy_id'), $this->mergeTokenData());
    }

    /**
     * 获取指定规则组下的企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/94882
     *
     * @throws GuzzleException
     */
    public function getTag(int $strategy_id, array $tag_id = [], array $group_id = []): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/get_strategy_tag_list', compact('strategy_id', 'tag_id', 'group_id'), $this->mergeTokenData());

        return $result['tag_group'] ?? [];
    }

    /**
     * 为指定规则组创建企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/94882
     *
     * @throws GuzzleException
     */
    public function addTag(array $data): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/add_strategy_tag', $data, $this->mergeTokenData());

        return $result['tag_group'];
    }

    /**
     * 编辑指定规则组下的企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/94882
     *
     * @throws GuzzleException
     */
    public function editTag(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/edit_strategy_tag', $data, $this->mergeTokenData());
    }

    /**
     * 删除指定规则组下的企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/94882
     *
     * @throws GuzzleException
     */
    public function delTag(array $tag_id = [], array $group_id = []): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/del_strategy_tag', compact('tag_id', 'group_id'), $this->mergeTokenData());
    }
}
