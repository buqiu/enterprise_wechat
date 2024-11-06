<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\ScopeBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed|string|null $external_user_id
 * @property int|mixed|null $transfer_err_code
 * @property mixed|string|null $handover_user_id
 * @property mixed|string|null $takeover_user_id
 * @property mixed|string|null $transfer_status
 * @property mixed|string|null $takeover_time
 * @property mixed|string|null $transfer_success_msg
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
class TransferCustomer extends Model
{
    use HasUlids, ScopeBuilder;

    protected $table = 'transfer_customers';

    protected $fillable = [
        'corp_id', 'handover_user_id', 'takeover_user_id', 'external_user_id',
    ];

    public const TRANSFER_ERR_CODE_SUCCESS = 0;
}
