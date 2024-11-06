<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;
use Buqiu\EnterpriseWechat\Contracts\ScopeBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed|string|null $msg_id
 * @property mixed|string|null $msg_key
 * @property mixed|string|null $msg_type
 * @property mixed|string|null $content
 * @property mixed|string|null $recall_status
 * @property mixed|string|null $welcome_code
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
class Message extends Model
{
    use HasUlids, ScopeBuilder;

    protected $table = 'messages';

    protected $fillable = [
        'corp_id',
    ];

    protected $casts = [
        'content' => JsonCast::class,
    ];

    // 消息类型
    public const MSG_TYPE_APP = 1;

    public const MSG_TYPE_BOT = 2;

    public const MSG_TYPE_GROUP = 3;

    public const MSG_TYPE_WELCOME = 4;

    // 撤回状态
    public const RECALL_STATUS_YES = 1;

    public const RECALL_STATUS_NO = 0;
}
