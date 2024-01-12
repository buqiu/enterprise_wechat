<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class ApiError
{
    public const ILLEGAL_METHOD            = 30001;
    public const RESPONSE_EMPTY            = 30002;
    public const INVALID_ERROR_CODE_TYPE   = 30003;
    public const RESPONSE_ERR              = 30004;
    public const ILLEGAL_CORP_ID_OR_SECRET = 30005;
    public const INVALID_PARAMS            = 30006;

    public const ERR_MSG = [
        self::ILLEGAL_METHOD            => '非法的请求方式',
        self::RESPONSE_EMPTY            => '暂无响应数据',
        self::INVALID_ERROR_CODE_TYPE   => '无效的错误码',
        self::RESPONSE_ERR              => '获取响应数据异常',
        self::ILLEGAL_CORP_ID_OR_SECRET => '非法的 corpid/secret',
        self::INVALID_PARAMS            => '无效的参数',
    ];
}
