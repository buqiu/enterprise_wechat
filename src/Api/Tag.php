<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Tag extends Api
{
    /**
     * 创建标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/90210
     *
     * @throws GuzzleException
     */
    public function create(array $data): int
    {
        $result = $this->httpPostJson('cgi-bin/tag/create', $data, $this->mergeTokenData());

        return $result['tagid'];
    }

    /**
     * 更新标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/90211
     *
     * @throws GuzzleException
     */
    public function update($data): array
    {
        return $this->httpPostJson('cgi-bin/tag/update', $data, $this->mergeTokenData());
    }

    /**
     * 删除标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/90212
     *
     * @throws GuzzleException
     */
    public function delete(int $tagid): array
    {
        return $this->httpGet('cgi-bin/tag/delete', $this->mergeTokenData(compact('tagid')));
    }

    /**
     * 获取标签成员
     *
     * https://developer.work.weixin.qq.com/document/path/90213
     *
     * @throws GuzzleException
     */
    public function get(int $tagid): array
    {
        $result = $this->httpGet('cgi-bin/tag/get', $this->mergeTokenData(compact('tagid')));

        return [$result['userlist'], $result['partylist']];
    }

    /**
     * 增加标签成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90214
     *
     * @throws GuzzleException
     */
    public function addTagUsers(int $tagid, array $userlist = [], array $partylist = []): array
    {
        return $this->httpPostJson('cgi-bin/tag/addtagusers', compact('tagid', 'userlist', 'partylist'), $this->mergeTokenData());
    }

    /**
     * 删除标签成员
     *
     * @link https://developer.work.weixin.qq.com/document/path/90215
     *
     * @throws GuzzleException
     */
    public function delTagUsers(int $tagid, array $userlist = [], array $partylist = []): array
    {
        return $this->httpPostJson('cgi-bin/tag/deltagusers', compact('tagid', 'userlist', 'partylist'), $this->mergeTokenData());
    }

    /**
     * 获取标签列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/90216
     *
     * @throws GuzzleException
     */
    public function list(): array
    {
        $result = $this->httpGet('cgi-bin/tag/list', $this->mergeTokenData());

        return $result['taglist'];
    }
}
