<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\JsonCast;

/**
 * @property mixed $id
 * @property mixed|string|null $template_id
 * @property mixed|string|null $text
 * @property mixed|string|null $image
 * @property mixed|string|null $link
 * @property mixed|string|null $mini_program
 * @property mixed|string|null $file
 * @property mixed|string|null $video
 * @property mixed|string|null $notify
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
class WelcomeTemplate extends Model
{
    protected $table = 'welcome_templates';

    protected $fillable = [
        'corp_id',
    ];

    protected $casts = [
        'text'         => JsonCast::class,
        'image'        => JsonCast::class,
        'link'         => JsonCast::class,
        'mini_program' => JsonCast::class,
        'file'         => JsonCast::class,
        'video'        => JsonCast::class,
    ];
}
