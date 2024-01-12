<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class ParamsError
{
    public const PARAMS_EMPTY = 50001;

    public const ERR_MSG = [
        self::PARAMS_EMPTY => '参数为空',
    ];
}
