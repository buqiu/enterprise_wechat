<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static whereCorpId($corp_id)
 * @method static whereDepartmentId($department_id)
 * @method static whereParentId($parent_id)
 * @property mixed|string $name
 * @property mixed|string $name_en
 * @property false|mixed|string $department_leader
 * @property int|mixed|null $parent_id
 * @property int|mixed|null $order
 * @property int|mixed|null $department_id
 * @property mixed|string|null $path
 */
class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'corp_id', 'department_id',
    ];

    protected $casts = [
        'path'              => JsonCast::class,
        'department_leader' => JsonCast::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }

    public function corp(): HasMany
    {
        return $this->hasMany(Corp::class, 'corp_id', 'corp_id');
    }
}
