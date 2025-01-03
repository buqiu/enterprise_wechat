<?php

declare(strict_types=1);

/**
 * 计算公众平台的消息签名接口.
 */

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\CryptError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;
use Exception;

class Sha
{
    /**
     * 用SHA1算法生成安全签名
     *
     * @param  string  $token  : 票据
     * @param  string  $timestamp  : 时间戳
     * @param  string  $nonce  : 随机字符串
     * @param  string  $encryptMsg  : 密文消息
     */
    public function getSha1(string $token, string $timestamp, string $nonce, string $encryptMsg): array
    {
        try {
            $params = [$encryptMsg, $token, $timestamp, $nonce];
            sort($params, SORT_STRING);

            return [Error::SUCCESS, sha1(implode($params))];
        } catch (Exception $e) {
            return [CryptError::COMPUTE_SIGNATURE_ERR, null];
        }
    }
}
