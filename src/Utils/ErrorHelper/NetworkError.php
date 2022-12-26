<?php

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class NetworkError
{
    const NETWORK_ERR     = 40001;
    const HTTP_STATUS_ERR = 40002;

    const ERR_MSG = [
        self::NETWORK_ERR     => '网络错误',
        self::HTTP_STATUS_ERR => '非预期的响应码'
    ];
}