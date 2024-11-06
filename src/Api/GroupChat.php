<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class GroupChat extends Api
{
    /**
     * 获取客户群列表
     *
     * @link https://developer.work.weixin.qq.com/document/path/92120
     *
     * @throws GuzzleException
     */
    public function list($data, int $limit = 1000): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/groupchat/list', array_merge(compact('limit'), $data), $this->mergeTokenData());

        return [$result['next_cursor'] ?? null, $result['group_chat_list']];
    }

    /**
     * 获取客户群详情
     *
     * @link https://developer.work.weixin.qq.com/document/path/92122
     *
     * @throws GuzzleException
     */
    public function get(string $chat_id, int $need_name = 1): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/groupchat/get', compact('chat_id', 'need_name'), $this->mergeTokenData());

        return $result['group_chat'];
    }

    /**
     * 客户群 opengid 转换
     *
     * @link https://developer.work.weixin.qq.com/document/path/94822
     *
     * @throws GuzzleException
     */
    public function opengIdToChatId(string $opengid): string
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/opengid_to_chatid', compact('opengid'), $this->mergeTokenData());

        return $result['chat_id'];
    }

    /**
     * 分配在职成员的客户群
     *
     * @link https://developer.work.weixin.qq.com/document/path/95703
     *
     * @throws GuzzleException
     */
    public function onJobTransfer(string $new_owner, array $chat_id_list): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/groupchat/onjob_transfer', compact('new_owner', 'chat_id_list'), $this->mergeTokenData());

        return $result['failed_chat_list'] ?? [];
    }

    /**
     * 分配离职成员的客户群
     *
     * @link https://developer.work.weixin.qq.com/document/p..ath/92127
     *
     * @throws GuzzleException
     */
    public function resignedTransfer(string $new_owner, array $chat_id_list): array
    {
        $result = $this->httpPostJson('/cgi-bin/externalcontact/groupchat/transfer', compact('new_owner', 'chat_id_list'), $this->mergeTokenData());

        return $result['failed_chat_list'] ?? [];
    }
}
