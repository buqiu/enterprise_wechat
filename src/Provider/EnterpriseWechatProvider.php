<?php

declare(strict_types=1);

/**
 * @note   服务提供者
 * @author mark
 */

namespace Buqiu\EnterpriseWechat\Provider;

use Illuminate\Support\ServiceProvider;

class EnterpriseWechatProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/qy.php' => config_path('qy.php'),
        ]);
    }
}
