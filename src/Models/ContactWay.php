<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function corp():HasMany
    {
        return $this->hasMany(Corp::class, 'corp_id', 'corp_id');
    }
}
