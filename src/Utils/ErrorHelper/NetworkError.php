<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class NetworkError
{
    public const NETWORK_ERR     = 40001;
    public const HTTP_STATUS_ERR = 40002;

    public const ERR_MSG = [
        self::NETWORK_ERR     => '网络错误',
        self::HTTP_STATUS_ERR => '非预期的响应码',
    ];
}
