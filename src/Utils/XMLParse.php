<?php

declare(strict_types=1);

/**
 * 提供提取消息格式中的密文及生成回复消息格式的接口.
 */

namespace Buqiu\EnterpriseWechat\Utils;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\CryptError;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\Error;

class XMLParse
{
    /**
     * 提取出 XML 数据包中的加密消息.
     *
     * @param $xmlParams
     * @return array
     */
    public function extract($xmlParams): array
    {
        try {
            $xml = new \DOMDocument();
            $xml->loadXML($xmlParams);
            $encryptArr = $xml->getElementsByTagName('Encrypt');
            $encrypt    = $encryptArr->item(0)->nodeValue;

            return [Error::SUCCESS, $encrypt];
        } catch (\Exception $e) {
            return [CryptError::PARSE_XML_ERR, null];
        }
    }
}
