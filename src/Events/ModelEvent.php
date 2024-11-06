<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ModelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $id) {}

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * 获取 corp code
     */
    public function getCorpCode()
    {
        return EnterpriseWechatFacade::getCode();
    }
}
