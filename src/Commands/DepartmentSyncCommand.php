<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Dto\DepartmentDto;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Services\SyncService;
use Exception;

class DepartmentSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:department:sync {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步部门';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $corp = Corp::whereCode($this->argument('code'))->firstOrFail();
        EnterpriseWechatFacade::connect(code: $corp->code);

        $this->info($this->description.'开始...');
        EnterpriseWechatFacade::department()->syncList();
        $this->info($this->description.'完成.');
    }
}
