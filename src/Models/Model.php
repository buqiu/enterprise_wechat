<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\ScopeBuilder;
use Buqiu\EnterpriseWechat\Contracts\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property mixed $id
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
class Model extends BaseModel
{
    use HasUlids, ScopeBuilder, SoftDeletes;

    protected $keyType = 'string';
}
