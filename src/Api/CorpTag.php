<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class CorpTag extends Api
{
    /**
     * 获取企业标签库
     *
     * @link https://developer.work.weixin.qq.com/document/path/92117
     * @throws GuzzleException
     */
    public function list(array $tag_id = [], array $group_id = []): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/get_corp_tag_list', compact(['tag_id', 'group_id']), $this->mergeTokenData());

        return $result['tag_group'];
    }

    /**
     * 添加企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/92117
     * @throws GuzzleException
     */
    public function create(array $data): array
    {
        $result = $this->httpPostJson('cgi-bin/externalcontact/add_corp_tag', $data, $this->mergeTokenData());

        return $result['tag_group'];
    }

    /**
     * 编辑企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/92117
     * @throws GuzzleException
     */
    public function update(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/edit_corp_tag', $data, $this->mergeTokenData());
    }

    /**
     * 删除企业客户标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/92117
     * @throws GuzzleException
     */
    public function delete(array $tag_id = [], array $group_id = []): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/del_corp_tag', compact('tag_id', 'group_id'), $this->mergeTokenData());
    }

    /**
     * 编辑客户企业标签
     *
     * @link https://developer.work.weixin.qq.com/document/path/92118
     * @throws GuzzleException
     */
    public function mark(array $data): array
    {
        return $this->httpPostJson('cgi-bin/externalcontact/mark_tag', $data, $this->mergeTokenData());
    }
}
