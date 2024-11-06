<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Libs;

use Buqiu\EnterpriseWechat\Services\BotService;
use Exception;

class Bot extends Lib
{
    /**
     * 发送消息
     *
     * @throws Exception
     */
    public function send(string $key, array $data): array
    {
        $botDto = BotService::checkCreateParams($key, $data);

        $this->api->send($key, $botDto->getData());

        BotService::send($key, $botDto);

        return $botDto->getData();
    }
}
