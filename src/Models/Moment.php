<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;

/**
 * @property mixed $id
 * @property mixed $job_id
 * @property mixed $text
 * @property mixed $attachments
 * @property mixed $visible_range
 * @property int|mixed|null $status
 * @property mixed|string|null $moment_id
 * @property mixed|string|null $invalid_sender_list
 * @property mixed|string|null $invalid_external_contact_list
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
class Moment extends Model
{
    protected $table = 'moments';

    protected $fillable = [
        'corp_id',
    ];

    protected $casts = [
        'text'                          => JsonCast::class,
        'attachments'                   => JsonCast::class,
        'visible_range'                 => JsonCast::class,
        'invalid_sender_list'           => JsonCast::class,
        'invalid_external_contact_list' => JsonCast::class,
        'task_list'                     => JsonCast::class,
        'customer_list'                 => JsonCast::class,
        'comment_list'                  => JsonCast::class,
        'like_list'                     => JsonCast::class,
    ];
}
