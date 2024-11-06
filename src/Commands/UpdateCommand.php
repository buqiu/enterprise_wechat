<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Utils\Utils;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修改企微账号';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->id = $this->choice('选择更新的账号?', Corp::all(['id', 'code'])->pluck('code', 'id')->toArray());

        $corp = Corp::findOrFail($this->id);

        $data = $this->getCorpAsks();

        $corp->fill($data);

        $this->view($corp);

        $this->confirmUpdate();

        $corp->updateRestore();

        $this->clearCache($corp->getKey());

        $this->components->info("账号({$corp->id})更新成功");
    }
}
