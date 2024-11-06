<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Exception;
use Illuminate\Support\Str;

abstract class CallBackAbstract
{
    public array $data = [];

    public bool $enable = true;

    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @throws Exception
     */
    public function __construct(public array $xmlArr)
    {
        $corpId = $xmlArr['ToUserName'] ?? null;

        if (! EnterpriseWechatFacade::getCorpId()) {
            EnterpriseWechatFacade::setCorpId($corpId);
        }

        if (! EnterpriseWechatFacade::getCorpId() || $corpId !== EnterpriseWechatFacade::getCorpId()) {
            throw new Exception('corp_id and callback corp_id are inconsistent');
        }
    }

    /**
     * @throws Exception
     */
    public function setData(): bool
    {
        $className = '\\Buqiu\\EnterpriseWechat\\Callback\\'.Str::studly($this->xmlArr['Event']).'\\'.Str::studly($this->xmlArr['ChangeType']);
        if (! class_exists($className)) {
            return false;
        }

        if (! method_exists($className, 'data')) {
            return false;
        }

        $this->data = ArrHelper::coverType(call_user_func([$className, 'data'], $this->xmlArr));

        return true;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getXmlData(): array
    {
        return $this->xmlArr;
    }
}
