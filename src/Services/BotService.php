<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\Message\BotDto;
use Buqiu\EnterpriseWechat\Models\Message;
use Exception;

class BotService
{
    /**
     * 检测入参(新建)
     *
     * @throws Exception
     */
    public static function checkCreateParams(string $key, array $data): BotDto
    {
        $botDto = new BotDto($data);
        $botDto->setKey($key);

        return $botDto;
    }

    /**
     * 发送应用消息
     *
     * @throws Exception
     */
    public static function send(string $msg_key, BotDto $botDto): Message
    {
        $botDto->setKey($msg_key);

        return SyncService::botMessage($botDto);
    }
}
