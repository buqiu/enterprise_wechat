<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Illuminate\Database\Eloquent\Builder;

trait ScopeBuilder
{
    public function scopeWithCorpId($builder): Builder
    {
        return $builder->whereCorpId(EnterpriseWechatFacade::getCorpId());
    }
}
