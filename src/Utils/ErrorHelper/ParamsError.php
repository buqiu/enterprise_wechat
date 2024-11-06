<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils\ErrorHelper;

class ParamsError
{
    const PARAMS_EMPTY = 50001;

    const PARAMS_DUPLICATION = 50002;

    const PARAMS_EXISTS = 50003;

    const ERR_MSG = [
        self::PARAMS_EMPTY       => '参数为空',
        self::PARAMS_DUPLICATION => '参数不能重复',
        self::PARAMS_EXISTS      => '数据不存在',
    ];
}
