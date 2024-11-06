<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

abstract class CallBackParam
{
    abstract public static function data(array $data): array;
}
