<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

/**
 * @property mixed $id
 * @property mixed $chat_id
 * @property array|mixed $status
 * @property mixed|string|null $name
 * @property mixed|string|null $owner_id
 * @property mixed|string|null $create_time
 * @property mixed|string|null $notice
 * @property mixed|string|null $member_version
 * @method static withCorpId()
 * @method static whereCorpId($corp_id)
 * @method static create(array $array)
 * @method static newModelQuery()
 * @method static newQuery()
 * @method static query()
 * @method static find(array|string $id)
 * @method static findOrFail($id)
 * @method static getModel()
 * @method static first()
 * @method static whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static insert()
 * @method static where($column, $value)
 */
class GroupChat extends Model
{
    protected $table = 'group_chats';

    protected $fillable = [
        'corp_id', 'notice', 'name', 'owner_id', 'member_version',
    ];

    protected $attributes = [
        'notice' => '',
    ];
}
