<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use GuzzleHttp\Exception\GuzzleException;

class AccessToken extends Api
{
    /**
     * 获取access_token
     *
     * @link https://developer.work.weixin.qq.com/document/path/91039
     *
     * @throws GuzzleException
     */
    public function getToken($corpid, $corpsecret): array
    {
        return $this->httpGet('/cgi-bin/gettoken', compact('corpid', 'corpsecret'));
    }
}
