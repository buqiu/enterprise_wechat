<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class GroupMessage extends Api
{
    /**
     * 创建企业群发
     *
     * @link https://developer.work.weixin.qq.com/document/path/92135
     *
     * @throws GuzzleException
     */
    public function addMsgTemplate(array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/add_msg_template', $data, $this->mergeTokenData());
    }

    /**
     * 提醒成员群发
     *
     * @link https://developer.work.weixin.qq.com/document/path/97610
     *
     * @throws GuzzleException
     */
    public function remindMsgSend(string $msgid): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/remind_groupmsg_send', compact('msgid'), $this->mergeTokenData());
    }

    /**
     * 停止企业群发
     *
     * @link https://developer.work.weixin.qq.com/document/path/97610
     *
     * @throws GuzzleException
     */
    public function cancelMsgSend(string $msgid): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/cancel_groupmsg_send', compact('msgid'), $this->mergeTokenData());
    }

    /**
     * 获取企业的全部群发记录
     *
     * @link https://developer.work.weixin.qq.com/document/path/93338
     *
     * @throws GuzzleException
     */
    public function getMsgListV2(array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/get_groupmsg_list_v2', $data, $this->mergeTokenData());
    }

    /**
     * 获取企业的全部群发记录
     *
     * @link https://developer.work.weixin.qq.com/document/path/93338
     *
     * @throws GuzzleException
     */
    public function getMsgTask(array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/get_groupmsg_task', $data, $this->mergeTokenData());
    }

    /**
     * 获取企业群发成员执行结果
     *
     * @link https://developer.work.weixin.qq.com/document/path/93338
     *
     * @throws GuzzleException
     */
    public function getMsgSendResult(array $data): array
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/get_groupmsg_send_result', $data, $this->mergeTokenData());
    }
}
