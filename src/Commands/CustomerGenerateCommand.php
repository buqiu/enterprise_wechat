<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;
use Buqiu\EnterpriseWechat\Models\User;
use Illuminate\Support\Collection;

class CustomerGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:customer:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成客户命令';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->id = $this->choice('选择要执行的账号?', Corp::all(['id', 'code'])->pluck('code', 'id')->toArray());

        $corp = Corp::findOrFail($this->id);

        $limit = $this->ask('请输入每次执行的条数', 10);

        if (is_int($limit)) {
            $this->error('页数需要为数字');
            exit;
        }

        User::whereCorpId($corp->corp_id)->orderBy('id')->chunk($limit, function (Collection $users) use ($corp) {

            if ($users->isNotEmpty()) {
                $firstUser = $users->first();

                $lastUser = $users->last();

                $this->line("php artisan enterprise-wechat:customer:sync {$corp->code} {$firstUser->id} {$lastUser->id}");
            }
        });

    }
}
