<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\ChangeExternalTag;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class Create extends CallBackParam
{
    public static function data(array $data): array
    {
        if ($data['TagType'] == 'tag') {
            return [
                [
                    'id'          => $data['Id']         ?? null,
                    'strategy_id' => $data['StrategyId'] ?? null,
                ],
                [],
            ];
        }

        // tag_group
        return [
            [],
            [
                'id'          => $data['Id']         ?? null,
                'strategy_id' => $data['StrategyId'] ?? null,
            ],
        ];
    }
}
