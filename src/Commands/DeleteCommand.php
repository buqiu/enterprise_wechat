<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;

class DeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除企微账号';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->id = $this->choice('选择删除的账号?', Corp::all(['id', 'code'])->pluck('code', 'id')->toArray());

        $this->confirmDelete();

        $corp = Corp::findOrFail($this->id);
        $corp->delete();

        app('cache')->forget(sprintf('enterprise_wechat:access_token:%s', $corp->getKey()));
        $this->components->info("账号({$corp->id})删除成功");
    }
}
