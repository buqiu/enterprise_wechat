<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;

class ContactWay extends Model
{
    protected $table = 'contact_ways';

    protected $fillable = [
        'corp_id',
    ];

    protected $casts = [
        'user_id'       => JsonCast::class,
        'department_id' => JsonCast::class,
        'conclusions'   => JsonCast::class,
    ];
}
