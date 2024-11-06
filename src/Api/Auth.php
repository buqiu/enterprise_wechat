<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Utils\Utils;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Auth extends Api
{
    /**
     * 获取授权链接
     *
     * @link https://developer.work.weixin.qq.com/document/path/91022
     *
     * @param  string  $callbackUrl  # 重定向 URL
     * @param  string  $scope  # 应用授权作用域
     * @param  string  $state  # state 参数
     * @return RedirectResponse
     */
    public function authorize(string $callbackUrl, string $scope, string $state): RedirectResponse
    {
        $corp = EnterpriseWechatFacade::getCorp();

        $queries = [
            'appid'         => $corp->corp_id,
            'redirect_uri'  => $callbackUrl,
            'response_type' => 'code',
            'scope'         => $scope,
            'state'         => $state,
            'agentid'       => $corp->agent_id,
        ];

        $url = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?%s#wechat_redirect', http_build_query($queries));

        return new RedirectResponse($url);
    }

    /**
     * Web 登录
     *
     * @link https://developer.work.weixin.qq.com/document/path/98152
     * @param  string  $callbackUrl  # 重定向 URL
     * @param  string  $login_type  # 登录类型
     * @param  string  $state  # state 参数
     * @param  string|null  $lang  # 语言类型
     * @return RedirectResponse
     */
    public function sso(string $callbackUrl, string $login_type, string $state, ?string $lang = null): RedirectResponse
    {
        $corp = EnterpriseWechatFacade::getCorp();

        $queries = [
            'login_type'   => $login_type,
            'appid'        => $corp->corp_id,
            'agentid'      => $corp->agent_id,
            'redirect_uri' => $callbackUrl,
            'state'        => $state,
        ];

        if (Utils::notEmpty($lang)) {
            $queries['lang'] = $lang;
        }

        $url = sprintf('https://login.work.weixin.qq.com/wwlogin/sso/login?%s#wechat_redirect', http_build_query($queries));

        return new RedirectResponse($url);
    }

    /**
     * 获取用户信息
     *
     * @link https://developer.work.weixin.qq.com/document/path/91023
     * @throws GuzzleException
     */
    public function getUserInfo(string $code): array
    {
        return $this->httpGet('cgi-bin/auth/getuserinfo', $this->mergeTokenData(compact('code')));
    }

    /**
     * 获取用户敏感信息
     *
     * @link https://developer.work.weixin.qq.com/document/path/95833
     * @throws GuzzleException
     */
    public function getUserDetail(string $user_ticket): array
    {
        return $this->httpPostJson('cgi-bin/auth/getuserdetail', compact('user_ticket'), $this->mergeTokenData());
    }

    /**
     * 获取用户二次验证信息
     *
     * @link https://developer.work.weixin.qq.com/document/path/99499
     * @throws GuzzleException
     */
    public function getTfaInfo(string $code): array
    {
        return $this->httpPostJson('cgi-bin/auth/getuserdetail', compact('code'), $this->mergeTokenData());
    }

    /**
     * 登录二次验证
     *
     * @link https://developer.work.weixin.qq.com/document/path/99521
     * @throws GuzzleException
     */
    public function authSuccess(string $user_id): array
    {
        return $this->httpGet('cgi-bin/user/authsucc', $this->mergeTokenData(['userid' => $user_id]));
    }

    /**
     * 使用二次验证
     *
     * @link https://developer.work.weixin.qq.com/document/path/99500
     * @throws GuzzleException
     */
    public function tfaSuccess(string $user_id, string $tfa_code): array
    {
        return $this->httpPostJson('cgi-bin/user/tfa_succ', ['userid' => $user_id, 'tfa_code' => $tfa_code], $this->mergeTokenData());
    }
}
