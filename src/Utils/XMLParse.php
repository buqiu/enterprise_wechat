<?php

declare(strict_types=1);

/**
 * 提供提取消息格式中的密文及生成回复消息格式的接口.
 */

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\CryptError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;
use DOMDocument;
use Exception;

class XMLParse
{
    /**
     * 提取出 XML 数据包中的加密消息
     */
    public function extract($xmlParams): array
    {
        try {
            $xml = new DOMDocument;
            $xml->loadXML($xmlParams);
            $encryptArr = $xml->getElementsByTagName('Encrypt');
            $encrypt    = $encryptArr->item(0)->nodeValue;

            return [Error::SUCCESS, $encrypt];
        } catch (Exception $e) {
            return [CryptError::PARSE_XML_ERR, null];
        }
    }

    /**
     * 生成xml消息
     */
    public function generate(string $encrypt, string $signature, string $timestamp, string $nonce): string
    {
        $format = '<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>';

        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }
}
