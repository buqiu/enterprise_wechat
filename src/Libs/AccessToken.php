<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AccessToken extends Lib
{
    /**
     * 获取缓存KEY值
     */
    public function getKey(): string
    {
        return sprintf('enterprise_wechat:access_token:%s', EnterpriseWechatFacade::getCorp()->getKey());
    }

    /**
     * 获取 Token
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getToken(): string
    {
        $token = app('cache')->get($this->getKey());
        if ($token && is_string($token)) {
            return $token;
        }

        return $this->refresh();
    }

    /**
     * 刷新 Token
     */
    public function refresh(): string
    {
        $coap = EnterpriseWechatFacade::getCorp();

        $response = $this->api->getToken($coap->corp_id, $coap->corp_secret);

        app('cache')->put($this->getKey(), $response['access_token'], (intval($response['expires_in']) - 200));

        return $response['access_token'];
    }

    /**
     * 清除 Token
     */
    public function clear(): void
    {
        app('cache')->forget($this->getKey());
    }
}
