<?php

declare(strict_types=1);
/**
 * 提供接收和推送给公众平台消息的加解密接口
 */

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\CryptError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;
use Exception;

class Encrypt
{
    public ?string $key = null;

    public ?string $iv = null;

    public function __construct($k)
    {
        $this->key = base64_decode($k.'=');
        $this->iv  = substr($this->key, 0, 16);
    }

    /**
     * 加密
     */
    public function encrypt($params, $receiveId): array
    {
        try {
            $params     = $this->getRandomStr().pack('N', strlen($params)).$params.$receiveId;
            $pkcEncoder = new PKCS7Encoder;
            $params     = $pkcEncoder->encode($params);
            // 加密
            $encrypted = openssl_encrypt($params, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);

            return [Error::SUCCESS, $encrypted];
        } catch (Exception $e) {
            return [CryptError::ENCRYPT_AES_ERR, null];
        }
    }

    /**
     * 解密
     */
    public function decrypt($encrypted, $receiveId): array
    {
        try {
            // 解密
            $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);
        } catch (Exception $e) {
            return [CryptError::DECRYPT_AES_ERR, null];
        }

        try {
            $pkcEncoder = new PKCS7Encoder;
            $result     = $pkcEncoder->decode($decrypted);
            if (strlen($result) < 16) {
                return [];
            }
            $content       = substr($result, 16, strlen($result));
            $lenList       = unpack('N', substr($content, 0, 4));
            $xmlLen        = $lenList[1];
            $xmlContent    = substr($content, 4, $xmlLen);
            $fromReceiveId = substr($content, $xmlLen + 4);
        } catch (Exception $e) {
            return [CryptError::ILLEGAL_BUFFER, null];
        }
        if ($fromReceiveId != $receiveId) {
            return [CryptError::VALIDATE_CORP_ID_ERR, null];
        }

        return [Error::SUCCESS, $xmlContent];
    }

    /**
     * 生成随机字符串
     */
    private function getRandomStr(): string
    {
        $str    = '';
        $strPol = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyl';
        $max    = strlen($strPol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $strPol[mt_rand(0, $max)];
        }

        return $str;
    }
}
