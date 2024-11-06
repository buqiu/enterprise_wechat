<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class Bot extends Api
{
    /**
     * 获取access_token
     *
     * @link https://developer.work.weixin.qq.com/document/path/91039
     *
     * @throws GuzzleException
     */
    public function send(string $key, array $data): array
    {
        return $this->httpPostJson('/cgi-bin/webhook/send', $data, ['key' => $key]);
    }
}
