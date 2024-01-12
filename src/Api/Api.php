<?php

declare(strict_types=1);

/**
 * 企业微信相关接口.
 */

namespace Buqiu\EnterpriseWechat\Api;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ApiError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;
use Buqiu\EnterpriseWechat\Utils\HttpUtils;
use Buqiu\EnterpriseWechat\Utils\Utils;

abstract class Api
{
    /**
     * 获取应用 access token.
     */
    public const GET_TOKEN = '/cgi-bin/gettoken?corpid=CORP_ID&corpsecret=SECRET';

    /**
     * 获取配置了客户联系功能的成员列表.
     */
    public const GET_FOLLOW_USER_LIST = '/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN';

    /**
     * 获取客户列表.
     */
    public const GET_EXTERNAL_CONTACT_LIST = '/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN';

    /**
     * 获取客户详情.
     */
    public const GET_EXTERNAL_CONTACT_INFO = '/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN';

    /**
     * 批量获取客户详情.
     */
    public const BATCH_GET_EXTERNAL_CONTACTS = '/cgi-bin/externalcontact/batch/get_by_user?access_token=ACCESS_TOKEN';

    /**
     * 修改客户备注信息.
     */
    public const REMARK = '/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN';

    /**
     * 管理企业标签.
     */
    public const GET_CORP_TAG_LIST = '/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';

    /**
     * 添加企业客户标签.
     */
    public const ADD_CORP_TAG = '/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN';

    /**
     * 编辑企业客户标签.
     */
    public const EDIT_CORP_TAG = '/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN';

    /**
     * 删除企业客户标签.
     */
    public const DEL_CORP_TAG = '/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN';

    /**
     * 编辑客户企业标签.
     */
    public const MARK_CORP_TAG = '/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN';

    /**
     * 分配在职成员客户.
     */
    public const EXTERNALCONTACT_TRANSFER_CUSTOMER = '/cgi-bin/externalcontact/transfer_customer?access_token=ACCESS_TOKEN';

    /**
     * 查询在职成员客户接替状态.
     */
    public const EXTERNALCONTACT_TRANSFER_RESULT = '/cgi-bin/externalcontact/transfer_result?access_token=ACCESS_TOKEN';

    /**
     * 分配在职成员的客户群.
     */
    public const EXTERNALCONTACT_GROUPCHAT_ONJOB_TRANSFER = '/cgi-bin/externalcontact/groupchat/onjob_transfer?access_token=ACCESS_TOKEN';

    /**
     * 分配离职成员客户.
     */
    public const RESIGNED_TRANSFER_CUSTOMER = '/cgi-bin/externalcontact/resigned/transfer_customer?access_token=ACCESS_TOKEN';

    /**
     * 查询离职成员客户接替状态.
     */
    public const RESIGNED_TRANSFER_RESULT = '/cgi-bin/externalcontact/resigned/transfer_result?access_token=ACCESS_TOKEN';

    /**
     * 分配离职成员的客户群.
     */
    public const EXTERNALCONTACT_GROUPCHAT_TRANSFER = '/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN';

    /**
     * 获取客户群列表.
     */
    public const EXTERNALCONTACT_GROUPCHAT = '/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN';

    /**
     * 获取客户群详情.
     */
    public const EXTERNALCONTACT_GROUPCHAT_GET = '/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN';

    /**
     * 创建企业群发.
     */
    public const ADD_MSG_TEMPLATE = '/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN';

    /**
     * 应用消息推送.
     */
    public const MESSAGE_SEND = '/cgi-bin/message/send?access_token=ACCESS_TOKEN';

    /**
     * 响应数据 json.
     */
    public $rspJson;

    /**
     * 响应数据 str.
     */
    public $rspRawStr;

    // 获取应用 access token
    protected function getAccessToken()
    {
    }

    // 刷新应用 access token
    protected function refreshAccessToken()
    {
    }

    /**
     * 发起请求
     *
     * @param  string     $url    请求的 URL 地址
     * @param  string     $method 请求方式
     * @param  array      $args   请求参数
     * @throws \Exception 异常
     */
    protected function _httpCall(string $url, string $method, array $args): void
    {
        if (!in_array($method, ['POST', 'GET'])) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::ILLEGAL_METHOD]);
        }

        switch ($method) {
            case 'POST':
                $url = HttpUtils::makeUrl($url);
                $this->_httpPostParseToJson($url, $args);
                $this->_checkErrCode();

                break;

            case 'GET':
                if (count($args) > 0) {
                    foreach ($args as $key => $value) {
                        if (null == $value) {
                            continue;
                        }
                        if (strpos($url, '?')) {
                            $url .= ('&'.$key.'='.$value);
                        } else {
                            $url .= ('?'.$key.'='.$value);
                        }
                    }
                }
                $url = HttpUtils::makeUrl($url);
                $this->_httpGetParseToJson($url);
                $this->_checkErrCode();

                break;

            default:
                break;
        }
    }

    /**
     * 将 GET 请求响应的数据转成 JSON 格式.
     * @param  string      $url
     * @param  bool        $refreshTokenWhenExpired
     * @return bool|string
     * @throws \Exception
     */
    protected function _httpGetParseToJson(string $url, bool $refreshTokenWhenExpired = true): bool|string
    {
        $retryCnt        = 0;
        $this->rspJson   = null;
        $this->rspRawStr = null;

        while ($retryCnt < 2) {
            $realUrl = $url;

            if (strpos($url, 'ACCESS_TOKEN')) {
                $token     = (string) $this->getAccessToken();
                $realUrl   = str_replace('ACCESS_TOKEN', $token, $url);
                $tokenType = 'ACCESS_TOKEN';
            } else {
                $tokenType = 'NO_TOKEN';
            }

            $this->rspRawStr = HttpUtils::httpGet($realUrl);

            if (!Utils::notEmptyStr($this->rspRawStr)) {
                throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
            }

            $this->rspJson = json_decode($this->rspRawStr, true);

            if (str_contains($this->rspRawStr, 'errcode')) {
                $errCode = Utils::arrayIsExist($this->rspJson, 'errcode');
                if (40014 == $errCode || 42001 == $errCode || 42007 == $errCode || 42009 == $errCode) {
                    if ('NO_TOKEN' != $tokenType && $refreshTokenWhenExpired) {
                        $this->refreshAccessToken();
                        ++$retryCnt;

                        continue;
                    }
                }
            }

            return $this->rspRawStr;
        }

        return '';
    }

    /**
     * 将 POST 请求响应的数据转成 JSON 格式.
     * @param  string      $url
     * @param  array       $args
     * @param  bool        $refreshTokenWhenExpired
     * @return array|mixed
     * @throws \Exception
     */
    protected function _httpPostParseToJson(string $url, array $args, bool $refreshTokenWhenExpired = true): mixed
    {
        $postData        = $args;
        $this->rspJson   = null;
        $this->rspRawStr = null;
        $retryCnt        = 0;

        while ($retryCnt < 2) {
            $realUrl = $url;

            if (strpos($url, 'ACCESS_TOKEN')) {
                $token     = (string) $this->getAccessToken();
                $realUrl   = str_replace('ACCESS_TOKEN', $token, $url);
                $tokenType = 'ACCESS_TOKEN';
            } else {
                $tokenType = 'NO_TOKEN';
            }
            $this->rspRawStr = HttpUtils::httpPost($realUrl, $postData);

            if (!Utils::notEmptyStr($this->rspRawStr)) {
                throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_EMPTY]);
            }

            $json          = json_decode($this->rspRawStr, true);
            $this->rspJson = $json;

            $errCode = Utils::arrayIsExist($this->rspJson, 'errcode');

            // token expired
            if (40014 == $errCode || 42001 == $errCode || 42007 == $errCode || 42009 == $errCode) {
                if ('NO_TOKEN' != $tokenType && true === $refreshTokenWhenExpired) {
                    $this->refreshAccessToken();
                    ++$retryCnt;

                    continue;
                }
            }

            return $json;
        }

        return [];
    }

    /**
     * 校验返回 code.
     * @throws \Exception
     */
    protected function _checkErrCode(): void
    {
        $rsp = $this->rspJson;
        $raw = $this->rspRawStr;
        if (empty($rsp)) {
            return;
        }

        if (!is_array($rsp)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::INVALID_PARAMS].' '.gettype($rsp));
        }

        if (!array_key_exists('errcode', $rsp)) {
            return;
        }

        if (!is_int($rsp['errcode'])) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::INVALID_ERROR_CODE_TYPE].' '.gettype($rsp['errcode']).':'.$raw);
        }

        if (Error::SUCCESS != $rsp['errcode']) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::RESPONSE_ERR].' '.$raw);
        }
    }
}
