<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class InternalError
{
    const SYSTEM_ERR = 10001;

    const MISSING_CURL_EXTEND_ERR = 10002;

    const ERR_MSG = [
        self::SYSTEM_ERR              => '系统内部错误',
        self::MISSING_CURL_EXTEND_ERR => '缺少 URL 扩展错误',
    ];
}
