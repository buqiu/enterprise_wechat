<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static connect(?string $id = null, ?string $code = null)
 * @method static getCorpId()
 * @method static setCorpId()
 * @method static getCode()
 * @method static getCorp()
 * @method static tag()
 * @method static accessToken()
 * @method static department()
 * @method static user()
 * @method static callBack()
 * @method static auth()
 * @method static corpTag()
 * @method static customer()
 * @method static message()
 * @method static bot()
 * @method static groupMessage()
 * @method static groupChat()
 * @method static media()
 * @method static strategy()
 * @method static welcome()
 * @method static moment()
 */
class EnterpriseWechatFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'enterprise_wechat';
    }
}
