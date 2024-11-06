<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Callback\UploadMediaJobFinish;

use Buqiu\EnterpriseWechat\Contracts\CallBackParam;

class UploadMediaJobFinish extends CallBackParam
{
    public static function data(array $data): array
    {
        return [
            'job_id' => $data['JobId'] ?? null,
        ];
    }
}
