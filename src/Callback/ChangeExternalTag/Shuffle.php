<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalTag;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class Shuffle extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            [],
            [
                'id'          => $data['Id']         ?? null,
                'strategy_id' => $data['StrategyId'] ?? null,
            ],
        ];
    }
}
