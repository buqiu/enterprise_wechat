<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string|null $tag_name
 * @property int|mixed|null $tag_id
 */
class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'corp_id', 'tag_id', 'tag_name',
    ];

    public function corp(): HasMany
    {
        return $this->hasMany(Corp::class, 'corp_id', 'corp_id');
    }
}
