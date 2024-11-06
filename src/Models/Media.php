<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\ScopeBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed|string|null $file_name
 * @property mixed|string|null $url
 * @property mixed|string|null $type
 * @property mixed|string|null $media_id
 * @property mixed|string|null $media_created_at
 * @property int|mixed|null $scene
 * @property mixed|string|null $file_md5
 * @property mixed|string|null $job_id
 * @property int|mixed|null $upload_status
 * @property mixed|string|null $err_msg
 * @property int|mixed $upload_mode
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
class Media extends Model
{
    use HasUlids, ScopeBuilder;

    protected $table = 'medias';

    protected $fillable = [
        'corp_id',
    ];

    public const UPLOAD_MODE_SYNC = 0;
    public const UPLOAD_MODE_ASYNC = 1;
}
