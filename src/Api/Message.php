<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Message extends Api
{
    /**
     * 发送应用消息
     *
     * @link https://developer.work.weixin.qq.com/document/path/90372
     *
     * @throws GuzzleException
     */
    public function send(array $data): array
    {
        return $this->httpPostJson('cgi-bin/message/send', $data, $this->mergeTokenData());
    }

    /**
     * 撤回应用消息
     *
     * @link https://developer.work.weixin.qq.com/document/path/94867
     *
     * @throws GuzzleException
     */
    public function recall(string $msg_id): array
    {
        return $this->httpPostJson('cgi-bin/message/recall', ['msgid' => $msg_id], $this->mergeTokenData());
    }
}
