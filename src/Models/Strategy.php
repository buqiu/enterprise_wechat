<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;

/**
 * @property int|mixed|null $strategy_id
 * @property int|mixed|null $parent_id
 * @property int|mixed|null $strategy_name
 * @property int|mixed|null $create_time
 * @property int|mixed|null $admin_list
 * @property array|mixed|null $privilege
 * @property array|mixed|null $range_user
 * @property array|mixed|null $range_party
 * @property array|mixed|null $tag_ids
 * @property array|mixed $path
 */
class Strategy extends Model
{
    protected $table = 'strategies';

    protected $fillable = [
        'corp_id',
    ];

    protected $casts = [
        'admin_list'  => JsonCast::class,
        'privilege'   => JsonCast::class,
        'range_user'  => JsonCast::class,
        'range_party' => JsonCast::class,
        'tag_ids'     => JsonCast::class,
        'path'        => JsonCast::class,
    ];
}
