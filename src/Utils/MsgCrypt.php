<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\CryptError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;

class MsgCrypt
{
    private string $m_sToken;

    private string $m_sReceiveId;

    private string $m_sEncodingAesKey;

    private int $m_sEncodingAesKeyLen = 43;

    /**
     * @param  string  $token  : 开发者设置的token
     * @param  string  $encodingAesKey  : 开发者设置的EncodingAESKey
     * @param  string  $receiveId  : 不同应用场景传不同的id
     */
    public function __construct(string $token, string $encodingAesKey, string $receiveId)
    {
        $this->m_sToken          = $token;
        $this->m_sEncodingAesKey = $encodingAesKey;
        $this->m_sReceiveId      = $receiveId;
    }

    /**
     * 验证 URL
     *
     * @param  string  $sMsgSignature  : 签名串, 对应 URL 参数的 msg_signature
     * @param  string  $sTimeStamp  : 时间戳, 对应 URL 参数的 timestamp
     * @param  string  $sNonce  : 随机串, 对应 URL 参数的 nonce
     * @param  string  $sEchoStr  : 随机串, 对应 URL 参数的 echostr
     * @param  string  $sReplyEchoStr  : 解密之后的 echostr, 当return 返回 0 时有效
     * @return int: 成功 0, 失败返回对应的错误码
     */
    public function verifyUrl(string $sMsgSignature, string $sTimeStamp, string $sNonce, string $sEchoStr, string &$sReplyEchoStr): int
    {
        if (strlen($this->m_sEncodingAesKey) != $this->m_sEncodingAesKeyLen) {
            return CryptError::ILLEGAL_AES_KEY;
        }

        $encryptClass = new Encrypt($this->m_sEncodingAesKey);
        $sha          = new Sha;
        $shaData      = $sha->getSha1($this->m_sToken, $sTimeStamp, $sNonce, $sEchoStr);

        if ($shaData[0] != Error::SUCCESS) {
            return $shaData[0];
        }

        if ($shaData[1] != $sMsgSignature) {
            return CryptError::VALIDATE_SIGNATURE_ERR;
        }

        $decryptData = $encryptClass->decrypt($sEchoStr, $this->m_sReceiveId);
        if ($decryptData[0] != Error::SUCCESS) {
            return $decryptData[0];
        }

        $sReplyEchoStr = $decryptData[1];

        return Error::SUCCESS;
    }

    /**
     * 将公众平台回复用户的消息加密打包.
     * <ol>
     *    <li>对要发送的消息进行AES-CBC加密</li>
     *    <li>生成安全签名</li>
     *    <li>将消息密文和安全签名打包成xml格式</li>
     * </ol>
     *
     * @param  string  $sReplyMsg  公众平台待回复用户的消息，xml格式的字符串
     * @param  string  $sTimeStamp  时间戳，可以自己生成，也可以用URL参数的timestamp
     * @param  string  $sNonce  随机串，可以自己生成，也可以用URL参数的nonce
     * @param  string  &$sEncryptMsg  加密后的可以直接回复用户的密文，包括msg_signature, timestamp, nonce, encrypt的xml格式的字符串,
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function encryptMsg(string $sReplyMsg, string $sTimeStamp, string $sNonce, string &$sEncryptMsg): int
    {
        $pc = new Encrypt($this->m_sEncodingAesKey);

        $array = $pc->encrypt($sReplyMsg, $this->m_sReceiveId);
        $ret   = $array[0];
        if ($ret != 0) {
            return $ret;
        }

        if ($sTimeStamp == null) {
            $sTimeStamp = time();
        }
        $encrypt = $array[1];

        $sha1  = new SHA;
        $array = $sha1->getSHA1($this->m_sToken, $sTimeStamp, $sNonce, $encrypt);
        $ret   = $array[0];
        if ($ret != 0) {
            return $ret;
        }
        $signature = $array[1];

        $xmlParse    = new XMLParse;
        $sEncryptMsg = $xmlParse->generate($encrypt, $signature, $sTimeStamp, $sNonce);

        return Error::SUCCESS;
    }

    /**
     * 检验消息的真实性，并且获取解密后的明文.
     * <ol>
     *    <li>利用收到的密文生成安全签名，进行签名验证</li>
     *    <li>若验证通过，则提取xml中的加密消息</li>
     *    <li>对消息进行解密</li>
     * </ol>
     *
     * @param  string  $sMsgSignature  : 签名串, 对应 URL 参数的 msg_signature
     * @param  string  $sNonce  : 随机串, 对应 URL 参数的 nonce
     * @param  string  $sPostData  : 密文, 对应 POST 请求的数据
     * @param  string  $sMsg  : 解密后的原文, 当 return 返回 0 时有效
     * @param  string|null  $sTimeStamp  : 时间戳对应 URL 参数的 timestamp
     * @return int: 成功 0, 失败返回对应的错误码
     */
    public function decryptMsg(string $sMsgSignature, string $sNonce, string $sPostData, string &$sMsg, ?string $sTimeStamp = null): int
    {
        if (strlen($this->m_sEncodingAesKey) != 43) {
            return CryptError::ILLEGAL_AES_KEY;
        }

        $pc = new Encrypt($this->m_sEncodingAesKey);

        //提取密文
        $xmlParse = new XMLParse;
        $array    = $xmlParse->extract($sPostData);

        if ($array[0] != Error::SUCCESS) {
            return $array[0];
        }

        if ($sTimeStamp == null) {
            $sTimeStamp = time();
        }

        $encrypt = $array[1];

        //验证安全签名
        $sha   = new Sha;
        $array = $sha->getSha1($this->m_sToken, $sTimeStamp, $sNonce, $encrypt);

        if ($array[0] != Error::SUCCESS) {
            return $array[0];
        }

        $signature = $array[1];
        if ($signature != $sMsgSignature) {
            return CryptError::VALIDATE_SIGNATURE_ERR;
        }

        $result = $pc->decrypt($encrypt, $this->m_sReceiveId);
        if ($result[0] != Error::SUCCESS) {
            return $result[0];
        }
        $sMsg = $result[1];

        return Error::SUCCESS;
    }
}
