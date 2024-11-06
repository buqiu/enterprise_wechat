<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

/**
 * @property mixed $id
 * @property mixed $chat_id
 * @property mixed|string|null $is_admin
 * @property mixed|string|null $type
 * @property mixed|string|null $user_id
 * @property mixed|string|null $union_id
 * @property mixed|string|null $join_time
 * @property mixed|string|null $join_scene
 * @property mixed|string|null $group_nick_name
 * @property mixed|string|null $name
 * @property mixed|string|null $invitor_user_id
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
class GroupChatMember extends Model
{
    protected $table = 'group_chat_members';

    protected $fillable = [
        'corp_id', 'chat_id',
    ];

    public const IS_ADMIN = 1;

    public const IS_NOT_ADMIN = 0;
}
