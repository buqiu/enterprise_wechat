<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed|null $corp_id
 * @property mixed|null $department_id
 * @property mixed|null $account_id
 * @property mixed|null $name
 * @property string|null $mobile
 * @property string|null $position
 * @property string|null $external_position
 * @property string|null $telephone
 * @property string|null $open_userid
 * @property string|null $thumb_avatar
 * @property string|null $avatar
 * @property string|null $direct_leader
 * @property string|null $email
 * @property string|null $biz_mail
 * @property string|null $gender
 * @property string|null $order
 * @property string|null $is_leader_in_dept
 * @property string|null $alias
 * @property string|null $ext_attr
 * @property string|null $address
 * @property array $external_profile
 * @property string|null $qr_code
 * @property int|null $status
 * @property array|null $tagIds
 * @property mixed $tag_ids
 */
class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'corp_id', 'account_id', 'customer_enabled', 'tag_ids', 'status',
    ];

    public const CUSTOMER_ENABLED = 1;

    public const CUSTOMER_DISABLE = 0;

    protected $casts = [
        'is_leader_in_dept' => JsonCast::class,
        'direct_leader'     => JsonCast::class,
        'ext_attr'          => JsonCast::class,
        'external_profile'  => JsonCast::class,
        'tag_ids'           => JsonCast::class,
    ];

    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class, 'id', 'user_id');
    }

    public function corp(): HasMany
    {
        return $this->hasMany(Corp::class, 'corp_id', 'corp_id');
    }

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
