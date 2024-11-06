<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Models;

use Buqiu\EnterpriseWechat\Contracts\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

/**
 * @method static whereCode(mixed $code)
 *
 * @property mixed $corp_id
 * @property mixed $code
 * @property mixed $corp_secret
 */
class Corp extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'corps';

    protected $keyType = 'string';

    protected $fillable = ['corp_id', 'corp_secret', 'code', 'token', 'encoding_aes_key', 'agent_id', 'describe'];
}
