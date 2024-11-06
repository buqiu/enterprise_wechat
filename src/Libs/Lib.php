<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;


use Buqiu\EnterpriseWechat\Api\Api;

class Lib
{
    public function __construct(public Api $api) {}

    public function __call(string $name, array $arguments)
    {
        return $this->api->$name(...$arguments);
    }

    public function api(): Api
    {
        return $this->api;
    }
}
