<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Buqiu\EnterpriseWechat\Utils\Utils;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait AttributeCast
{
    public function json(): Attribute
    {
        return new Attribute(
            get: fn ($value) => json_decode($value ?: '[]', true),
            set: fn ($value) => Utils::empty($value) ? null : json_encode($value ?: [], JSON_UNESCAPED_UNICODE),
        );
    }
}
