<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Utils\MsgCrypt;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;

class CallBack extends Api
{
    public ?MsgCrypt $msgCrypt = null;

    public function __construct()
    {
        $corp           = EnterpriseWechatFacade::getCorp();
        $this->msgCrypt = new MsgCrypt($corp->token, $corp->encoding_aes_key, $corp->corp_id);
    }

    /**
     * 验证回调
     *
     * @param  string  $msgSignature  : 签名串
     * @param  string  $timeStamp  : 时间戳
     * @param  string  $nonce  : 随机串
     * @param  string  $echoStr  : 随机串
     * @throws Exception
     *
     * @link https://developer.work.weixin.qq.com/document/path/90967
     */
    public function verifyUrl(string $msgSignature, string $timeStamp, string $nonce, string $echoStr): string
    {
        $replyEchoStr = '';
        $errCode      = $this->msgCrypt->verifyUrl($msgSignature, $timeStamp, $nonce, $echoStr, $replyEchoStr);
        if ($errCode) {
            throw new Exception('Enterprise Wechat Verify Err: '.$errCode);
        }

        return $replyEchoStr;
    }

    /**
     * 获取解密明文
     *
     * @param  string  $sMsgSignature  : 签名串
     * @param  string  $sNonce  : 随机串
     * @param  string  $sTimeStamp  : 时间戳
     * @param  string  $sPostData  : 密文
     * @throws Exception
     *
     * @link https://developer.work.weixin.qq.com/document/path/90967
     */
    public function notify(string $sMsgSignature, string $sNonce, string $sTimeStamp, string $sPostData): array
    {
        $sMsg    = '';
        $errCode = $this->msgCrypt->decryptMsg($sMsgSignature, $sNonce, $sPostData, $sMsg, $sTimeStamp);
        if ($errCode) {
            throw new Exception('Enterprise Wechat Notice Err: '.$errCode);
        }

        return Utils::Xml2Array($sMsg);
    }
}
