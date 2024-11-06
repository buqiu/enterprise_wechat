<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\ScopeBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed|string|null $chat_id
 * @property mixed|string|null $new_user_id
 * @property mixed|string|null $transfer_err_code
 * @property mixed|string|null $transfer_err_msg
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
class TransferGroupChat extends Model
{
    use HasUlids, ScopeBuilder;

    protected $table = 'transfer_group_chats';

    protected $fillable = [
        'corp_id', 'new_user_id',
    ];
}
