<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\CallBackService;
use Buqiu\EnterpriseWechat\Utils\LogHelper;
use Exception;

class CallBack extends Lib
{
    /**
     * 验证回调
     *
     * @throws Exception
     */
    public function verifyUrl(): string
    {
        LogHelper::info(__CLASS__.'\\'.__FUNCTION__, request()->all());

        $data = CallBackService::checkVerifyUrlData(request()->all());

        return $this->api->verifyUrl(...$data);
    }

    /**
     * 回调通知
     *
     * @throws Exception
     */
    public function notify()
    {
        $data = CallBackService::checkNotifyData(request()->all());

        $result = $this->api->notify(...$data);

        LogHelper::info(__CLASS__.'\\'.__FUNCTION__, $result);

        CallBackService::notify($result);

        return $result;
    }
}
