<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|null $corp_id
 * @property string|null $external_user_id
 * @property string|null $name
 * @property string|null $avatar
 * @property int|null $type
 * @property int|null $gender
 * @property string|null $union_id
 * @property string|null $position
 * @property string|null $corp_name
 * @property string|null $corp_full_name
 * @property array|null $external_profile
 * @property string|null $user_id
 * @property string|null $remark
 * @property string|null $description
 * @property string|null $create_time
 * @property array|null $tag_ids
 * @property string|null $remark_company
 * @property array|null $remark_mobiles
 * @property int|null $add_way
 * @property array|null $wechat_channels
 * @property string|null $operate_userid
 * @property string|null $state
 * @property array|mixed|string[] $extra
 * @property string|mixed $welcome_code
 */
class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'corp_id', 'external_user_id',
    ];

    protected $casts = [
        'external_profile' => JsonCast::class,
        'remark_mobiles'   => JsonCast::class,
        'wechat_channels'  => JsonCast::class,
        'tag_ids'          => JsonCast::class,
        'extra'            => JsonCast::class,
    ];

    public function getCorpTagNameAttribute(): array
    {
        if ($this->tag_ids) {
            return CorpTag::query()->whereIn('tag_id', $this->tag_ids)->pluck('name', 'tag_id')->toArray();
        }

        return [];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function corp(): HasMany
    {
        return $this->hasMany(Corp::class, 'corp_id', 'corp_id');
    }

    public function getTagsAttribute()
    {
        return CorpTag::where('corp_id', $this->corp_id)->whereIn('tag_id', $this->tag_ids)->get();
    }
}
