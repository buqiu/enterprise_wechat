<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Events;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $model = null;

    public function __construct(public array $data = [], public array $xmlData = [])
    {
        $this->model = $this->bind();
    }

    /**
     * 处理的数据
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 原数据
     *
     * @return array
     */
    public function getXmlData(): array
    {
        return $this->xmlData;
    }

    /**
     * 获取 corp code
     */
    public function getCorpCode()
    {
        return EnterpriseWechatFacade::getCode();
    }

    public function bind(): mixed
    {
        return null;
    }

    public function __get(string $name)
    {
        if (is_null($this->model)) {
            return $this->model;
        }

        if ($this->model instanceof Model) {
            return object_get($this->model, $name);
        }

        if ($this->model instanceof Collection) {
            return $this->model->pluck($name)->toArray();
        }

        if (is_array($this->model)) {
            return array_column($this->model, $name);
        }

        return $this->model;
    }

    public function __call(string $name, array $arguments)
    {
        $key = Str::snake(Str::substr($name, 3));

        return $this->$key;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('wechat-name'),
        ];
    }
}
