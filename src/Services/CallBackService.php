<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Enums\CallEventEnum;
use Buqiu\EnterpriseWechat\Enums\CallMsgTypeEnum;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Exception;
use Illuminate\Support\Str;

class CallBackService
{
    /**
     * 检验回调入参
     *
     * @param  array  $data
     * @return array
     * @throws Exception
     */
    public static function checkVerifyUrlData(array $data): array
    {
        ArrHelper::validatorEmpty($data, ['msg_signature', 'timestamp', 'nonce', 'echostr']);

        return [
            $data['msg_signature'],
            $data['timestamp'],
            $data['nonce'],
            $data['echostr'],
        ];
    }

    /**
     * 检验事件接收入参
     *
     * @param  array  $data
     * @return array
     * @throws Exception
     */
    public static function checkNotifyData(array $data): array
    {
        ArrHelper::validatorEmpty($data, ['msg_signature', 'timestamp', 'nonce']);

        return [
            $data['msg_signature'],
            $data['nonce'],
            $data['timestamp'],
            request()->getContent(),
        ];
    }

    /**
     * 回调执行
     *
     * @throws Exception
     */
    public static function notify(array $data): void
    {
        if (ArrHelper::isEmpty($data, ['MsgType', 'Event'])) {
            return;
        }

        if (! CallMsgTypeEnum::exist($data['MsgType']) || ! CallEventEnum::exist($data['Event'])) {
            return;
        }

        if (ArrHelper::isEmpty($data, 'ChangeType')) {
            $data['ChangeType'] = $data['Event'];
        }

        $className = '\\Buqiu\\EnterpriseWechat\\Callback\\'.Str::studly($data['Event']);
        if (! class_exists($className)) {
            return;
        }

        $class = new $className($data);
        if (! call_user_func([$class, 'setData'])) {
            return;
        }

        $changeType = Str::camel($data['ChangeType']);
        if (! method_exists($className, $changeType)) {
            return;
        }

        if (! call_user_func([$class, 'isEnable'])) {
            return;
        }

        call_user_func([$class, $changeType]);

        $eventClass = '\\Buqiu\\EnterpriseWechat\\Events\\'.Str::studly($data['Event']).'\\'.Str::studly($data['ChangeType']).'Event';
        if (! class_exists($eventClass)) {
            return;
        }
        $eventClass::dispatch(call_user_func([$class, 'getData']), call_user_func([$class, 'getXmlData']));
    }
}
