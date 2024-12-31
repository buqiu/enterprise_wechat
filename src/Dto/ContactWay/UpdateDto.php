<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto\ContactWay;

use Buqiu\EnterpriseWechat\Dto\ContactWayDto;

class UpdateDto extends ContactWayDto
{
    protected array $valid_require_property = [
        'config_id',
    ];
}
