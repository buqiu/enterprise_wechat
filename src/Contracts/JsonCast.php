<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Buqiu\EnterpriseWechat\Utils\Utils;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return json_decode($value ?: '[]', true);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return Utils::empty($value) ? null : json_encode($value ?: [], JSON_UNESCAPED_UNICODE);
    }
}
