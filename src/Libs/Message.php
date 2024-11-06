<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\MessageService;
use Exception;

class Message extends Lib
{
    /**
     * 发送应用消息
     *
     * @throws Exception
     */
    public function send(array $data): array
    {
        $messageDto = MessageService::checkCreateParams($data);

        $messageDto->setData($this->api->send($messageDto->getData()));

        MessageService::send($messageDto);

        return $messageDto->getData();
    }

    /**
     * 撤回应用消息
     *
     * @throws Exception
     */
    public function recall(string $msg_id): void
    {
        $this->api->recall($msg_id);

        MessageService::recall($msg_id);
    }
}
