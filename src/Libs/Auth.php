<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

class Auth extends Lib
{
    /**
     * 静默授权登录
     */
    public function redirectBase(string $callbackUrl, string $state = 'state'): mixed
    {
        return $this->api->authorize($callbackUrl, 'snsapi_base', $state);
    }

    /**
     * 手动授权登录
     */
    public function redirectPrivateInfo(string $callbackUrl, string $state = 'state'): mixed
    {
        return $this->api->authorize($callbackUrl, 'snsapi_privateinfo', $state);
    }

    /**
     * 服务商登录
     */
    public function redirectServiceApp(string $callbackUrl, string $state = 'state', ?string $lang = null): mixed
    {
        return $this->api->sso($callbackUrl, 'ServiceApp', $state, $lang);
    }

    /**
     * 企业自建/代开发应用登录
     */
    public function redirectCorpApp(string $callbackUrl, string $state = 'state', ?string $lang = null): mixed
    {
        return $this->api->sso($callbackUrl, 'CorpApp', $state, $lang);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo(string $code): mixed
    {
        return $this->api->getUserInfo($code);
    }

    /**
     * 获取用户敏感信息
     */
    public function getUserDetail(string $user_ticket): mixed
    {
        return $this->api->getUserDetail($user_ticket);
    }

    /**
     * 获取用户二次验证信息
     */
    public function getTfaInfo(string $code)
    {
        return $this->api->getTfaInfo($code);
    }

    /**
     * 登录二次验证
     */
    public function authSuccess(string $user_id)
    {
        return $this->api->tfaSuccess($user_id);
    }

    /**
     * 使用二次验证
     */
    public function tfaSuccess(string $user_id, string $tfa_code)
    {
        return $this->api->tfaSuccess($user_id, $tfa_code);
    }
}
