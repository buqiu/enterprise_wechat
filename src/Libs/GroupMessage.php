<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\GroupMessageService;
use Exception;

class GroupMessage extends Lib
{
    /**
     * 群发消息
     *
     * @throws Exception
     */
    public function send(array $data): array
    {
        $messageDto = GroupMessageService::checkCreateParams($data);

        $messageDto->setData($this->api->addMsgTemplate($messageDto->getParams()));

        GroupMessageService::send($messageDto);

        return $messageDto->getData();
    }

    /**
     * 提醒成员群发
     *
     * @throws Exception
     */
    public function remind(string $msg_id): void
    {
        $this->api->remindMsgSend($msg_id);
    }


    /**
     * 停止企业群发
     *
     * @throws Exception
     */
    public function cancel(string $msg_id): void
    {
        $this->api->cancelMsgSend($msg_id);

        GroupMessageService::cancel($msg_id);
    }
}
