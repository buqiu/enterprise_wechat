<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

/**
 * @property string|null $group_id
 * @property string|null $tag_id
 * @property string|null $group_name
 * @property string|null $group_create_time
 * @property string|null $group_order
 * @property string|null $name
 * @property string $create_time
 * @property int|null $order
 */
class StrategyTag extends Model
{
    protected $table = 'strategy_tags';

    protected $fillable = [
        'corp_id', 'group_id', 'tag_id', 'group_name', 'group_create_time', 'group_order', 'name', 'create_time', 'order',
    ];
}
