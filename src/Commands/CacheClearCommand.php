<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;

class CacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:cache-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理缓存';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $corps = Corp::all(['id']);
        foreach ($corps as $corp) {
            $this->clearCache($corp->getKey());
        }
        $this->components->info('清理缓存完成');
    }
}
