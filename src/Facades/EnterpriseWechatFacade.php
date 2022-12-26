<?php

namespace Buqiu\EnterpriseWechat\Facades;

use Illuminate\Support\Facades\Facade;

class EnterpriseWechatFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'enterprise_wechat';
    }
}